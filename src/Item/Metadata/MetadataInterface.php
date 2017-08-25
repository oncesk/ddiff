<?php

namespace DDiff\Item\Metadata;

/**
 * Interface MetadataInterface
 * @package DDiff\Item\Metadata
 */
interface MetadataInterface
{
    /**
     * @return string
     */
    public function getRawType() : string;

    /**
     * @return string
     */
    public function getType() : string;

    /**
     * @return bool
     */
    public function isInteger() : bool;

    /**
     * @return bool
     */
    public function isString() : bool;

    /**
     * @return mixed|null
     */
    public function getDefaultValue();
}
