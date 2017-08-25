<?php

namespace DDiff\Item;

use DDiff\Exception\NotFountException;

/**
 * Class Item
 * @package DDiff\Item
 */
class Item implements ItemInterface
{
    /**
     * @var FieldInterface[]
     */
    protected $fields = [];

    /**
     * @param string $name
     * @return FieldInterface
     * @throws NotFountException
     */
    public function getField(string $name): FieldInterface
    {
        if ($this->hasField($name)) {
            return $this->fields[$name];
        }

        throw new NotFountException("Field $name not found");
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasField(string $name): bool
    {
        return isset($this->fields[$name]);
    }

    /**
     * @param FieldInterface $field
     * @return ItemInterface
     */
    public function addField(FieldInterface $field): ItemInterface
    {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
