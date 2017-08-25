<?php

namespace DDiff\Destination\Item\Finder;

use DDiff\Csv\Reader;
use DDiff\Csv\ReaderInterface;
use DDiff\Database\Schema\FieldInterface;
use DDiff\Database\Schema\PrimaryKeyAwareInterface;
use DDiff\Destination\Item\FinderInterface;
use DDiff\Exception\DDiffException;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Exception\NotFountException;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Item\Context\ContextAwareTrait;
use DDiff\Item\Context\ContextInterface;
use DDiff\Item\IdentifiableInterface;
use DDiff\Item\Item;
use DDiff\Item\ItemInterface;
use DDiff\Item\NullableItem;
use DDiff\Item\PrimaryKeyAwareItem;
use DDiff\Item\ValueField;
use DDiff\Model\ConfigurableInterface;

/**
 * Class CsvFinder
 * @package DDiff\Destination\Item\Finder
 */
class CsvFinder implements FinderInterface, ConfigurableInterface, ContextAwareInterface
{
    use ContextAwareTrait;

    /**
     * @var ReaderInterface
     */
    protected $reader;

    /**
     * @var array
     */
    protected $records;

    /**
     * @inheritdoc
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @param ContextInterface $context
     * @throws InvalidConfigurationException
     */
    public function configure(ContextInterface $context)
    {
        if (!$context->has('csv.dst.file')) {
            throw new InvalidConfigurationException('Could not find csv.dst.file context property');
        }

        $file = $context->get('csv.dst.file');
        $this->reader = new Reader($file);

        if (filesize($file) <= 2e+7) {
            try {
                while (!$this->reader->eof()) {
                    $assoc = $this->reader->read();
                    if ($assoc) {
                        $this->records[] = $assoc;
                    }
                }
            } catch (DDiffException $exception) {}
        }
    }

    /**
     * @param ItemInterface $item
     * @return ItemInterface
     * @throws DDiffException
     */
    public function find(ItemInterface $item): ItemInterface
    {
        $idFields = [];
        if ($item instanceof IdentifiableInterface) {
            $idFields[] = $item->getId()->getName();
        } else if ($item instanceof PrimaryKeyAwareInterface) {
            foreach ($item->getPrimaryKey()->getFields()->getFields() as $field) {
                $idFields[] = $field->getName();
            }
        }

        if (empty($idFields)) {
            throw new DDiffException('Do not known how to find in csv, no identifiable fields!');
        }

        if (!empty($this->records)) {
            $destinationRecord = null;
            foreach ($this->records as $record) {
                $found = true;
                foreach ($idFields as $field) {
                    if ($record[$field] != $item->getField($field)->getValue()) {
                        $found = false;
                        break;
                    }
                }

                if ($found) {
                    $destinationRecord = $record;
                    break;
                }
            }
            if ($destinationRecord) {
                if ($item instanceof PrimaryKeyAwareInterface) {
                    $destination = new PrimaryKeyAwareItem();
                    $destination->setPrimaryKey($item->getPrimaryKey());
                } else {
                    $destination = new Item();
                }

                foreach ($destinationRecord as $key => $value) {
                    $destination->addField(new ValueField($key, $value));
                }

                return $destination;
            }
        }

        throw new NotFountException();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'csv';
    }
}
