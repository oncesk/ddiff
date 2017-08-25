<?php

namespace DDiff\Database\Schema;

/**
 * Interface FieldInterface
 * @package DDiff\Database\Schema
 */
interface FieldInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return bool
     */
    public function isPrimaryKey() : bool;

    /**
     * @return string
     */
    public function getRawType() : string;

    /**
     * @return string|mixed
     */
    public function getDefault();
}
