<?php

namespace DDiff\Database\Schema;

/**
 * Class PrimaryKeyAwareTrait
 * @package DDiff\Database\Schema
 */
trait PrimaryKeyAwareTrait
{
    /**
     * @var PrimaryKeyInterface
     */
    private $primaryKey;

    /**
     * @return PrimaryKeyInterface
     */
    public function getPrimaryKey() : PrimaryKeyInterface
    {
        if (null === $this->primaryKey) {
            $this->primaryKey = new PrimaryKey();
        }

        return $this->primaryKey;
    }

    /**
     * @param PrimaryKeyInterface $primaryKey
     * @return $this
     */
    public function setPrimaryKey(PrimaryKeyInterface $primaryKey)
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }
}
