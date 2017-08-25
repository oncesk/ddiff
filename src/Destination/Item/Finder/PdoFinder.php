<?php

namespace DDiff\Destination\Item\Finder;

use DDiff\Configuration\Database\DatabaseFactoryInterface;
use DDiff\Database\PdoProviderInterface;
use DDiff\Database\Schema\PrimaryFieldInterface;
use DDiff\Database\Schema\PrimaryKeyAwareInterface;
use DDiff\Database\Schema\TableInterface;
use DDiff\Destination\Item\FinderInterface;
use DDiff\Exception\DatabaseException;
use DDiff\Exception\DDiffException;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Exception\NotFountException;
use DDiff\Item\Context\Context;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Item\Context\ContextAwareTrait;
use DDiff\Item\Context\ContextInterface;
use DDiff\Item\IdentifiableInterface;
use DDiff\Item\IdentifiableItem;
use DDiff\Item\ItemInterface;
use DDiff\Item\PrimaryKeyAwareItem;
use DDiff\Item\ValueAwareInterface;
use DDiff\Item\ValueField;
use DDiff\Source\Provider\Database\PdoTableProvider;
use DDiff\Source\Provider\ProviderFactoryInterface;
use DDiff\Source\Provider\ProviderInterface;
use DDiff\Database\Schema\ProviderInterface as DatabaseSchemaProviderInterface;

/**
 * Class PdoFinder
 * @package DDiff\Destination\Item\Finder
 */
class PdoFinder implements FinderInterface, ContextAwareInterface, ProviderFactoryInterface
{
    use ContextAwareTrait;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var PdoProviderInterface
     */
    protected $pdoProvider;

    /**
     * @var TableInterface
     */
    protected $table;

    /**
     * @var DatabaseFactoryInterface
     */
    protected $databaseConfigurationFactory;

    /**
     * @var DatabaseSchemaProviderInterface
     */
    protected $schemaProvider;

    /**
     * PdoTableProvider constructor.
     * @param PdoProviderInterface $pdoProvider
     * @param DatabaseFactoryInterface $databaseFactory
     * @param DatabaseSchemaProviderInterface $schemaProvider
     */
    public function __construct(
        PdoProviderInterface $pdoProvider,
        DatabaseFactoryInterface $databaseFactory,
        DatabaseSchemaProviderInterface $schemaProvider
    )
    {
        $this->pdoProvider = $pdoProvider;
        $this->databaseConfigurationFactory = $databaseFactory;
        $this->schemaProvider = $schemaProvider;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'db.pdo.table.finder';
    }

    /**
     * @param ContextInterface $context
     * @return ProviderInterface
     */
    public function createSourceProvider(ContextInterface $context): ProviderInterface
    {
        $provider = new PdoTableProvider(
            $this->pdoProvider,
            $this->databaseConfigurationFactory,
            $this->schemaProvider
        );
        $provider->setContext(new Context([
            'db.src.config' => $context->get('db.dst.config'),
            'db.src.table' => $context->get('db.dst.table')
        ]));

        return $provider;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $context = $this->getContext();
        $this->validateContext($context);

        $configurationName = $context->get('db.dst.config');
        $table = $context->get('db.dst.table');

        $configuration = $this->databaseConfigurationFactory->createConfigurationByName($configurationName);
        $this->pdo = $this->pdoProvider->getPdoInstance($configuration);
        $schema = $this->schemaProvider->getSchema($this->pdo, $configuration);

        if (!$schema->getTables()->hasTable($table)) {
            throw new DatabaseException('Table not found in database');
        }
        $this->table = $schema->getTables()->getTable($table);
    }

    /**
     * @param ItemInterface $item
     * @throws NotFountException
     * @return ItemInterface
     */
    public function find(ItemInterface $item) : ItemInterface
    {
        $destinationItem = $this->doFind($item);

        if (!$destinationItem) {
            $transformed = $this->transformToValidRepresentation($item);
            $destinationItem = $this->doFind($transformed);
        }

        if ($destinationItem) {
            return $destinationItem;
        }

        throw new NotFountException();
    }

    protected function doFind(ItemInterface $item)
    {
        if ($item instanceof PrimaryKeyAwareInterface) {
            $primaryKey = $item->getPrimaryKey();
            $query = sprintf(
                "SELECT * FROM `%s` WHERE %s",
                $this->table,
                implode(" AND ", array_map(function (PrimaryFieldInterface $field) {
                    return sprintf(
                        '`%s` = :%s',
                        $field->getName(),
                        $field->getName()
                    );
                }, $primaryKey->getFields()->getFields()))
            );

            $stmt = $this->pdo->prepare($query);
            $arguments = [];
            foreach ($primaryKey->getFields()->getFields() as $field) {
                $itemField = $item->getField($field->getName());
                $arguments[':' . $field->getName()] = $itemField->getValue();
            }
            $result = $stmt->execute($arguments);

            if (false === $result) {
                throw new NotFountException();
            }

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (false === $result) {
                throw new NotFountException();
            }

            $dstItem = new PrimaryKeyAwareItem();
            $dstItem->setPrimaryKey($primaryKey);
            foreach ($result as $key => $value) {
                $dstItem->addField(new ValueField($key, $value));
            }
            return $dstItem;
        }

        if ($item instanceof IdentifiableInterface) {
            $id = $item->getId();

            if ($id instanceof ValueAwareInterface) {
                $stmt = $this->pdo->prepare(sprintf(
                    "SELECT * FROM `%s` WHERE %s = :id",
                    $this->table,
                    $id->getName()
                ));
                $result = $stmt->execute([
                    ':id' => $id->getValue()
                ]);

                if (false === $result) {
                    throw new NotFountException();
                }

                $result = $stmt->fetch(\PDO::FETCH_ASSOC);

                if (false === $result) {
                    throw new NotFountException();
                }

                $dstItem = new IdentifiableItem($id);
                foreach ($result as $key => $value) {
                    $dstItem->addField(new ValueField($key, $value));
                }
                return $dstItem;
            }
        }

        return null;
    }

    /**
     * @param ItemInterface $item
     * @throws DDiffException
     *
     * @return ItemInterface
     */
    protected function transformToValidRepresentation(ItemInterface $item)
    {
        $destination = new PrimaryKeyAwareItem();
        $destination->setPrimaryKey($this->table->getPrimaryKey());

        foreach ($this->table->getFields() as $field) {
            if (!$item->hasField($field->getName())) {
                throw new DDiffException('Different structure of source and destination');
            }
            $destination->addField($item->getField($field->getName()));
        }

        return $destination;
    }

    /**
     * @param ContextInterface $context
     * @throws InvalidConfigurationException
     */
    protected function validateContext(ContextInterface $context)
    {
        if (!$context) {
            throw new InvalidConfigurationException('Please pass context to PdoFinder');
        }

        if (!$context->has('db.dst.config')) {
            throw new InvalidConfigurationException(
                'Please pass context variable, db.dst.config throught --context option. Example: -c db.dst.config=test'
            );
        }

        if (!$context->has('db.dst.table')) {
            throw new InvalidConfigurationException(
                'Please pass context variable, db.src.table throught --context option. Example: -c db.src.table=test'
            );
        }
    }
}
