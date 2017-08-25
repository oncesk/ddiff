<?php

namespace DDiff\Database\Schema;

use DDiff\Exception\NotFountException;

/**
 * Class TableInterface
 * @package DDiff\Database\Schema
 */
interface TableInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return FieldCollectionInterface|FieldInterface[]
     */
    public function getFields() : FieldCollectionInterface;

    /**
     * @return bool
     */
    public function hasPrimaryKey() : bool;

    /**
     * @return PrimaryKeyInterface
     */
    public function getPrimaryKey() : PrimaryKeyInterface;

    /**
     * @return string
     */
    public function __toString();
}
