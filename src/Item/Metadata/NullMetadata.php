<?php

namespace DDiff\Item\Metadata;

use DDiff\Stub\NullObjectInterface;

/**
 * Class NullMetadata
 * @package DDiff\Item\Metadata
 */
class NullMetadata implements MetadataInterface, NullObjectInterface
{
    /**
     * @return string
     */
    public function getRawType(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return '';
    }

    /**
     * @return null
     */
    public function getDefaultValue()
    {
        return null;
    }

    public function isInteger(): bool
    {
        return false;
    }

    public function isString(): bool
    {
        return false;
    }
}
