<?php

namespace DDiff\Database\Schema;

/**
 * Class TableAwareTrait
 * @package DDiff\Database\Schema
 */
class TableAwareTrait
{
    /**
     * @var TableInterface
     */
    private $table;

    /**
     * @return TableInterface
     */
    public function getTable() : TableInterface
    {
        return $this->table;
    }

    /**
     * @param TableInterface $table
     * @return $this
     */
    public function setTable(TableInterface $table)
    {
        $this->table = $table;

        return $this;
    }
}
