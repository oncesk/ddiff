<?php

namespace DDiff\Destination\Item;

use DDiff\Destination\Item\ChangeSet\ChangeSetCollectionInterface;
use DDiff\Destination\Item\ChangeSet\ChangeSetInterface;
use DDiff\Item\ItemInterface;

/**
 * Class StateInterface
 * @package DDiff\Destination
 */
interface StateInterface
{
    /**
     * @return bool
     */
    public function isNew() : bool;

    /**
     * @return bool
     */
    public function isModified() : bool;

    /**
     * @return bool
     */
    public function isFound() : bool;

    /**
     * @return bool
     */
    public function isRemoved() : bool;

    /**
     * @return ItemInterface
     */
    public function getSourceItem() : ItemInterface;

    /**
     * @return ItemInterface|null
     */
    public function getDestinationItem();

    /**
     * @return ChangeSetInterface[]|ChangeSetCollectionInterface
     */
    public function getChanges() : ChangeSetCollectionInterface;
}
