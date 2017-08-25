<?php

namespace DDiff\Destination\Item\ChangeSet;

/**
 * Class ChangeSetCollectionInterface
 * @package DDiff\Destination\Item\ChangeSet
 */
interface ChangeSetCollectionInterface extends \IteratorAggregate
{
    /**
     * @return ChangeSetInterface[]
     */
    public function getChanges() : array;

    /**
     * @return bool
     */
    public function hasChanges() : bool;
}
