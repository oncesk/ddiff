<?php

namespace DDiff\Database\Schema;

/**
 * Interface FieldCollectionInterface
 * @package DDiff\Database\Schema
 */
interface FieldCollectionInterface extends \IteratorAggregate, \Countable
{
    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name) : bool;

    /**
     * @param string $name
     * @return FieldInterface
     */
    public function get(string $name) : FieldInterface;

    /**
     * @param FieldInterface $field
     * @return $this
     */
    public function add(FieldInterface $field);

    /**
     * @return FieldInterface[]
     */
    public function getFields() : array;
}
