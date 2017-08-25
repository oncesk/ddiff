<?php

namespace DDiff\Model;

/**
 * Class TypeResolver
 * @package DDiff\Model
 */
class TypeResolver implements TypeResolverInterface
{
    /**
     * @param $data
     * @return int
     */
    public function resolveType($data): int
    {
        if ($this->isInteger($data)) {
            return static::TYPE_INTEGER;
        } else if ($this->isString($data)) {
            return static::TYPE_STRING;
        }

        return static::TYPE_UNKNOWN;
    }

    /**
     * @param $data
     * @return bool
     */
    public function isInteger($data): bool
    {
        return is_numeric($data);
    }

    /**
     * @param $data
     * @return bool
     */
    public function isString($data): bool
    {
        return is_string($data);
    }
}
