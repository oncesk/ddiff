<?php

namespace DDiff\Source\Provider\Database;

use DDiff\Configuration\Database\DatabaseFactoryInterface;
use DDiff\Database\PdoProviderInterface;
use DDiff\Database\Schema\FieldCollectionInterface;
use DDiff\Database\Schema\PrimaryKeyAwareInterface;
use DDiff\Database\Schema\PrimaryKeyAwareTrait;
use DDiff\Database\Schema\PrimaryKeyInterface;
use DDiff\Destination\Item\Finder\PdoFinder;
use DDiff\Destination\Item\FinderFactoryInterface;
use DDiff\Destination\Item\FinderInterface;
use DDiff\Exception\DatabaseException;
use DDiff\Exception\DDiffException;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Item\Context\Context;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Item\Context\ContextAwareTrait;
use DDiff\Item\Context\ContextInterface;
use DDiff\Item\FieldInterface;
use DDiff\Item\IdentifiableInterface;
use DDiff\Item\Item;
use DDiff\Item\ItemInterface;
use DDiff\Item\Metadata\Metadata;
use DDiff\Item\Metadata\MetadataAwareInterface;
use DDiff\Item\Metadata\MetadataInterface;
use DDiff\Item\ValueAwareInterface;
use DDiff\Item\ValueField;
use DDiff\Source\Provider\ProviderInterface;
use DDiff\Database\Schema\ProviderInterface as SchemaProviderInterface;

/**
 * Class DatabaseProvider
 * @package DDiff\Source\Provider\Database
 */
class PdoTableProvider implements ProviderInterface, ContextAwareInterface, FinderFactoryInterface
{
    use ContextAwareTrait;

    /**
     * @var PdoProviderInterface
     */
    protected $pdoProvider;

    /**
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * @var ItemInterface
     */
    protected $item;

    /**
     * @var ItemInterface
     */
    protected $prototype;

    /**
     * @var MetadataInterface[]
     */
    protected $metadatas = [];

    /**
     * @var DatabaseFactoryInterface
     */
    protected $databaseConfigurationFactory;

    /**
     * @var SchemaProviderInterface
     */
    protected $schemaProvider;

    /**
     * PdoTableProvider constructor.
     * @param PdoProviderInterface $pdoProvider
     * @param DatabaseFactoryInterface $databaseFactory
     * @param SchemaProviderInterface $schemaProvider
     */
    public function __construct(
        PdoProviderInterface $pdoProvider,
        DatabaseFactoryInterface $databaseFactory,
        SchemaProviderInterface $schemaProvider
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
        return 'db.pdo';
    }

    /**
     * @param ContextInterface $context
     * @return FinderInterface
     */
    public function createDestinationFinder(ContextInterface $context): FinderInterface
    {
        $this->validateContext($context);

        $finder = new PdoFinder($this->pdoProvider, $this->databaseConfigurationFactory, $this->schemaProvider);
        $finder->setContext(new Context([
            'db.dst.config' => $context->get('db.src.config'),
            'db.dst.table' => $context->get('db.src.table')
        ]));

        return $finder;
    }

    /**
     * Initialize
     */
    public function init()
    {
        $this->metadatas = [];

        $context = $this->getContext();
        $this->validateContext($context);

        $configurationName = $context->get('db.src.config');
        $table = $context->get('db.src.table');

        $configuration = $this->databaseConfigurationFactory->createConfigurationByName($configurationName);
        $pdo = $this->pdoProvider->getPdoInstance($configuration);
        $schema = $this->schemaProvider->getSchema($pdo, $configuration);

        if (!$schema->getTables()->hasTable($table)) {
            throw new DatabaseException('Table [' . $table . '] not found in database ');
        }

        $table = $schema->getTables()->getTable($table);

        $primaryKey = null;
        if ($table->hasPrimaryKey()) {
            $primaryKey = $table->getPrimaryKey();
        }

        $this->createMetadataObjects($table->getFields());
        $this->createPrototype($primaryKey);

        $this->statement = $pdo->prepare("SELECT * FROM `{$table->getName()}`");
        $this->statement->execute();
    }

    public function eof()
    {
        $data = $this->statement->fetch(\PDO::FETCH_ASSOC);
        if (false === $data) {
            return true;
        }

        $this->item = $this->createItem();
        foreach ($data as $key => $value) {
            $field = $this->createField($key, $value);
            $this->item->addField($field);

            if ($field instanceof MetadataAwareInterface && isset($this->metadatas[$key])) {
                $field->setMetadata($this->metadatas[$key]);
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * @return ItemInterface
     */
    public function getSourceItem(): ItemInterface
    {
        return $this->item;
    }

    /**
     * @return ItemInterface
     */
    protected function createItem()
    {
        $item = clone $this->prototype;

        return $item;
    }

    /**
     * @param string $name
     * @param null $value
     *
     * @return ValueField|FieldInterface|ValueAwareInterface
     */
    protected function createField(string $name, $value = null)
    {
        $field =  new ValueField($name, $value);
        return $field;
    }

    /**
     * @param FieldCollectionInterface $collection
     */
    protected function createMetadataObjects(FieldCollectionInterface $collection)
    {
        foreach ($collection->getFields() as $field) {
            $this->metadatas[$field->getName()] = $this->createMetadata($field);
        }
    }

    /**
     * @param \DDiff\Database\Schema\FieldInterface $field
     * @return MetadataInterface
     */
    protected function createMetadata(\DDiff\Database\Schema\FieldInterface $field)
    {
        $type = $field->getRawType();
        if (preg_match('/([a-zA-Z]+)[^\(]/', $field->getRawType(), $matches)) {
            $type = $matches[0];

            switch ($type) {
                case 'int':
                case 'integer':
                    break;

                case 'varchar':
                case 'text':
                    $type = 'string';
                    break;
            }

        }
        return new Metadata($field->getRawType(), $type, $field->getDefault());
    }

    /**
     * @param PrimaryKeyInterface $primaryKey
     */
    protected function createPrototype(PrimaryKeyInterface $primaryKey = null)
    {
        if ($primaryKey) {
            $this->prototype = new class ($primaryKey) extends Item implements PrimaryKeyAwareInterface {

                use PrimaryKeyAwareTrait;

                /**
                 * __anonymous$\DDiff\Source\Item\Item$\DDiff\Source\Item\IdentifiableInterface@1581 constructor.
                 * @param PrimaryKeyInterface $primaryKey
                 */
                public function __construct(PrimaryKeyInterface $primaryKey)
                {
                    $this->setPrimaryKey($primaryKey);
                }
            };
        } else {
            $this->prototype = new Item();
        }
    }

    /**
     * @param ContextInterface $context
     * @throws InvalidConfigurationException
     */
    protected function validateContext(ContextInterface $context)
    {
        if (!$context) {
            throw new InvalidConfigurationException('Please pass context to PdoTableProvider');
        }

        if (!$context->has('db.src.config')) {
            throw new InvalidConfigurationException(
                'Please pass context variable, db.src.config throught --context option. Example: -c db.src.config=test'
            );
        }

        if (!$context->has('db.src.table')) {
            throw new InvalidConfigurationException(
                'Please pass context variable, db.src.table throught --context option. Example: -c db.src.table=test'
            );
        }
    }
}
