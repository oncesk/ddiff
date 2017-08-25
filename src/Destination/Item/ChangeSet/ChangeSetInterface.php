<?php

namespace DDiff\Destination\Item\ChangeSet;

use DDiff\Item\FieldInterface;

/**
 * Interface ChangeSetInterface
 * @package DDiff\Destination\Item\ChangeSet
 */
interface ChangeSetInterface
{
    /**
     * @return FieldInterface
     */
    public function getField() : FieldInterface;

    /**
     * @return mixed
     */
    public function was();

    /**
     * @return mixed
     */
    public function became();
}
