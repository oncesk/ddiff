<?php

namespace DDiff\Database\Schema;

/**
 * Interface PrimaryKeyInterface
 * @package DDiff\Database\Schema
 */
interface PrimaryKeyInterface
{
    /**
     * @return FieldCollectionInterface|FieldInterface[]
     */
    public function getFields() : FieldCollectionInterface;
}
