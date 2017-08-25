<?php

namespace DDiff\Item;

use DDiff\Exception\NotFountException;

/**
 * Interface ItemInterface
 */
interface ItemInterface
{
    /**
     * @param string $name
     * @throws NotFountException
     * @return FieldInterface
     */
    public function getField(string $name) : FieldInterface;

    /**
     * @param string $name
     * @return bool
     */
    public function hasField(string $name) : bool;

    /**
     * @param FieldInterface $field
     * @return ItemInterface
     */
    public function addField(FieldInterface $field) : ItemInterface;

    /**
     * @return FieldInterface[]
     */
    public function getFields() : array;
}
