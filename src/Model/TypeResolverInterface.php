<?php

namespace DDiff\Model;

/**
 * Interface TypeResolverInterface
 * @package DDiff\Model
 */
interface TypeResolverInterface
{
    const TYPE_INTEGER = 1;
    const TYPE_STRING = 2;
    const TYPE_UNKNOWN = 100;

    /**
     * @param $data
     * @return int
     */
    public function resolveType($data) : int;

    /**
     * @param $data
     * @return bool
     */
    public function isInteger($data) : bool;

    /**
     * @param $data
     * @return bool
     */
    public function isString($data) : bool;
}
