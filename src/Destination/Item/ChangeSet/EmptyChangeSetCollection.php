<?php

namespace DDiff\Destination\Item\ChangeSet;

use DDiff\Stub\NullObjectInterface;

/**
 * Class EmptyChangeSetCollection
 * @package DDiff\Destination\Item\ChangeSet
 */
class EmptyChangeSetCollection implements ChangeSetCollectionInterface, NullObjectInterface
{
    /**
     * @return array
     */
    public function getChanges(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    public function hasChanges(): bool
    {
        return false;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator([]);
    }
}
