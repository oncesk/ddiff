<?php

namespace DDiff\Destination\Item;

use DDiff\Destination\Item\ChangeSet\ChangeSetCollectionInterface;
use DDiff\Destination\Item\ChangeSet\EmptyChangeSetCollection;
use DDiff\Item\Item;
use DDiff\Item\ItemInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class NullObjectState
 * @package DDiff\Destination\Item
 */
class NullObjectState implements StateInterface, NullObjectInterface
{
    /**
     * @var ItemInterface
     */
    protected $source;

    /**
     * @var ChangeSetCollectionInterface
     */
    protected $collection;

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isModified(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRemoved(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isFound(): bool
    {
        return false;
    }

    /**
     * @return ItemInterface
     */
    public function getSourceItem(): ItemInterface
    {
        if (null === $this->source) {
            $this->source = new Item();
        }

        return $this->source;
    }

    /**
     * @return null
     */
    public function getDestinationItem()
    {
        return null;
    }

    /**
     * @return ChangeSetCollectionInterface
     */
    public function getChanges(): ChangeSetCollectionInterface
    {
        if (null === $this->collection) {
            $this->collection = new EmptyChangeSetCollection();
        }

        return $this->collection;
    }
}
