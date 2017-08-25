<?php

namespace DDiff\Result\Formatter;

use DDiff\Configuration\ConfigurationInterface;
use DDiff\Database\Schema\PrimaryFieldInterface;
use DDiff\Database\Schema\PrimaryKeyAwareInterface;
use DDiff\Destination\Item\ChangeSet\ChangeSetCollectionInterface;
use DDiff\Destination\Item\ChangeSet\ChangeSetInterface;
use DDiff\Destination\Item\Finder\Context\DestinationTableContextInterface;
use DDiff\Destination\Item\StateInterface;
use DDiff\Item\Context\ContextInterface;
use DDiff\Item\FieldInterface;
use DDiff\Item\IdentifiableInterface;
use DDiff\Item\Metadata\MetadataAwareInterface;
use DDiff\Item\ValueAwareInterface;
use DDiff\Model\TypeResolverInterface;
use DDiff\Result\FormatterHeaderAwareInterface;
use DDiff\Result\FormatterInterface;
use DDiff\Source\Provider\Database\Context\SourceTableContextInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class SqlFormatter
 * @package DDiff\Result\Formatter
 */
class SqlFormatter implements FormatterInterface, FormatterHeaderAwareInterface
{
    /**
     * @var TypeResolverInterface
     */
    protected $typeResolver;

    /**
     * SqlFormatter constructor.
     * @param TypeResolverInterface $typeResolver
     */
    public function __construct(TypeResolverInterface $typeResolver)
    {
        $this->typeResolver = $typeResolver;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'sql';
    }

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return string|null
     */
    public function formatHeader(ConfigurationInterface $configuration)
    {
        $context = $configuration->getContext();
        $header = [
            "# SQL Formatter"
        ];

        if ($context->has('db.src.table')) {
            $header[] = "# Source table: {$context->get('db.src.table')}";
        }

        if ($context->has('db.dst.table')) {
            $header[] = "# Destination table: {$context->get('db.dst.table')}";
        }

        return implode("\n", $header);
    }

    /**
     * @param StateInterface $state
     * @param ContextInterface $context
     *
     * @return string|null
     */
    public function format(StateInterface $state, ContextInterface $context)
    {
//        if (!$context->has('db.src.table') || !$context->has('db.dst.table')) {
//            throw new \LogicException('Could not generate sql statements because of source or destination table not passed');
//        }

        if (!$context->has('db.dst.table')) {
            throw new \LogicException('Could not generate sql statements because of source or destination table not passed');
        }

        $changes = $state->getChanges();

        if ($changes->hasChanges() && $state->isModified()) {
            return $this->generateUpdate($state, $changes, $context);
        } else if ($state->isNew()) {
            return $this->generateInsert($state, $changes, $context);
        } else if ($state->isRemoved()) {
            return $this->generateDelete($state, $context);
        }

        return null;
    }

    /**
     * @param StateInterface $state
     * @param ContextInterface $context
     *
     * @return string
     */
    protected function generateDelete(StateInterface $state, ContextInterface $context)
    {
        $table = $context->get('db.src.table');
        if ($context->has('db.remove.table')) {
            $table = $context->get('db.remove.table');
        }

        $source = $state->getSourceItem();

        if ($source instanceof IdentifiableInterface) {
            $value = $source->getId()->getValue();

            if ($this->typeResolver->isString($value)) {
                $value = sprintf(
                    "'%s'",
                    addcslashes($source->getId()->getValue(), "'")
                );
            }

            return sprintf(
                "DELETE FROM `%s` WHERE `%s` = %s;",
                $table,
                $source->getId()->getName(),
                $value
            );
        } else if ($source instanceof PrimaryKeyAwareInterface) {
            return sprintf(
                "DELETE FROM `%s` WHERE %s;",
                $table,
                implode(" AND ", array_map(function (PrimaryFieldInterface $field) use ($source) {
                    $value = $source->getField($field->getName())->getValue();
                    if ($this->typeResolver->isInteger($value)) {
                        return sprintf(
                            "`%s` = %s",
                            $field->getName(),
                            $value
                        );
                    } else if ($this->typeResolver->isString($value)) {
                        return sprintf(
                            "`%s` = '%s'",
                            $field->getName(),
                            addcslashes($value, "'")
                        );
                    }
                }, $source->getPrimaryKey()->getFields()->getFields()))
            );
        }

        throw new \LogicException('Destination item should implement IdentifiableInterface or PrimaryKeyAwareInterface');
    }

    /**
     * @param StateInterface $state
     * @param ChangeSetCollectionInterface $collection
     * @param ContextInterface $context
     *
     * @return string
     */
    protected function generateInsert(StateInterface $state, ChangeSetCollectionInterface $collection, ContextInterface $context)
    {
        $source = $state->getSourceItem();

        return sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s);",
            $context->get('db.dst.table'),
            implode(", ", array_map(function (FieldInterface $field) {
                return "`{$field->getName()}`";
            }, $source->getFields())),
            implode(", ", array_map(function (FieldInterface $field) {

                //  todo must be refactored!!!!!!!!
                //  holy crap
                if (!$field instanceof ValueAwareInterface) {
                    throw new \LogicException('Could not generate insert because field has no value');
                }

                $value = $field->getValue();

                switch ($this->typeResolver->resolveType($value)) {
                    case TypeResolverInterface::TYPE_INTEGER:
                        return $value;
                        break;

                    case TypeResolverInterface::TYPE_STRING:
                        return sprintf(
                            "'%s'",
                            addcslashes($value, "'")
                        );
                        break;

                    default:
                        return 'null';
                }
            }, $source->getFields()))
        );
    }

    /**
     * @param StateInterface $state
     * @param ChangeSetCollectionInterface $collection
     * @param ContextInterface $context
     *
     * @return string
     */
    protected function generateUpdate(StateInterface $state, ChangeSetCollectionInterface $collection, ContextInterface $context)
    {
        $destination = $state->getDestinationItem();
        $table = $context->get('db.dst.table');

        if ($destination instanceof PrimaryKeyAwareInterface) {
            $query = sprintf(
                "UPDATE `%s` SET %s WHERE %s;",
                $table,
                $this->createUpdateFiledsString($collection),
                implode(" AND ", array_map(function (PrimaryFieldInterface $field) use ($destination) {
                        $value = $destination->getField($field->getName())->getValue();
                        switch ($this->typeResolver->resolveType($value)) {

                            case TypeResolverInterface::TYPE_INTEGER:
                                return sprintf(
                                    "`%s` = %s",
                                    $field->getName(),
                                    $value
                                );
                                break;

                            case TypeResolverInterface::TYPE_STRING:
                            default:
                                return sprintf(
                                    "`%s` = '%s'",
                                    $field->getName(),
                                    addcslashes($value, "'")
                                );
                                break;
                        }
                    }, $destination->getPrimaryKey()->getFields()->getFields())
                )
            );
            return $query;
        }

        if ($destination instanceof IdentifiableInterface) {
            $id = $destination->getId();
            $type = 'string';

            if (!$id instanceof ValueAwareInterface) {
                throw new \LogicException('Could not generate update query because of ID Field has no ValueAwareInterface');
            }

            if ($id instanceof MetadataAwareInterface) {
                $type = $id->getMetadata()->getType();
            }

            return sprintf(
                'UPDATE `%s` SET %s WHERE %s;',
                $table,
                $this->createUpdateFiledsString($collection),
                $this->formatField($id, $type) ?? '1 = 1'
            );
        }

        throw new \LogicException('Destination item should implement IdentifiableInterface or PrimaryKeyAwareInterface');
    }

    protected function createUpdateFiledsString(ChangeSetCollectionInterface $collection)
    {
        return implode(", ", array_map(function (ChangeSetInterface $changeSet) {
            $field = $changeSet->getField();
            $type = "string";
            if ($field instanceof MetadataAwareInterface && !$field instanceof NullObjectInterface) {
                $type = $field->getMetadata()->getType();
            }

            return $this->formatField($field, $type);

        }, $collection->getChanges()));
    }

    /**
     * @param FieldInterface|ValueAwareInterface $field
     * @param string $type
     * @return string
     */
    protected function formatField(FieldInterface $field, string $type)
    {
        switch ($type) {

            case 'int':
            case 'double':
            case 'float':
                return sprintf(
                    '`%s` = %s',
                    $field->getName(),
                    $field->getValue()
                );
                break;

            case 'string':
            default:
                return sprintf(
                    '`%s` = "%s"',
                    $field->getName(),
                    addcslashes($field->getValue(), '"')
                );
                break;
        }
    }
}
