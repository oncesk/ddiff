<?php

namespace DDiff\Database;

use DDiff\Database\Schema\TableCollectionInterface;

/**
 * Class SchemaInterface
 * @package DDiff\Database
 */
interface SchemaInterface
{
    /**
     * @return string
     */
    public function getDatabaseName() : string;

    /**
     * @return TableCollectionInterface
     */
    public function getTables() : TableCollectionInterface;
}
