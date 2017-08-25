<?php

namespace DDiff\Database\Schema;

/**
 * Interface PrimaryKeyAwareInterface
 * @package DDiff\Database\Schema
 */
interface PrimaryKeyAwareInterface
{
    /**
     * @return PrimaryKeyInterface
     */
    public function getPrimaryKey() : PrimaryKeyInterface;

    /**
     * @param PrimaryKeyInterface $primaryKey
     * @return $this
     */
    public function setPrimaryKey(PrimaryKeyInterface $primaryKey);
}
