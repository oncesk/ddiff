<?php

namespace DDiff\Item;

use DDiff\Exception\NotFountException;
use DDiff\Stub\NullObjectInterface;

/**
 * Class NullableItem
 * @package DDiff\Item
 */
class NullableItem implements ItemInterface, NullObjectInterface
{
    /**
     * @param string $name
     * @return FieldInterface
     * @throws NotFountException
     */
    public function getField(string $name): FieldInterface
    {
        throw new NotFountException('Field not found because item is nullable');
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasField(string $name): bool
    {
        return false;
    }

    /**
     * @param FieldInterface $field
     * @return ItemInterface
     */
    public function addField(FieldInterface $field): ItemInterface
    {
        return $this;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return [];
    }
}
