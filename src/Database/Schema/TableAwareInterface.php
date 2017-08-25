<?php

namespace DDiff\Database\Schema;

/**
 * Interface TableAwareInterface
 * @package DDiff\Database\Schema
 */
interface TableAwareInterface
{
    /**
     * @return TableInterface
     */
    public function getTable() : TableInterface;

    /**
     * @param TableInterface $table
     * @return $this
     */
    public function setTable(TableInterface $table);
}
