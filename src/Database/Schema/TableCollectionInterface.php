<?php

namespace DDiff\Database\Schema;

use DDiff\Exception\DatabaseException;
use DDiff\Exception\NotFountException;

/**
 * Interface TableCollectionInterface
 * @package DDiff\Database\Schema
 */
interface TableCollectionInterface extends \IteratorAggregate
{
    /**
     * @param string $name
     * @return bool
     */
    public function hasTable(string $name) : bool;

    /**
     * @param string $name
     * @throws NotFountException
     * @throws DatabaseException
     * @return TableInterface
     */
    public function getTable(string $name) : TableInterface;

    /**
     * @return TableInterface[]
     */
    public function getTables() : array;
}
