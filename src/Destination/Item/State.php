<?php

namespace DDiff\Destination\Item;

use DDiff\Destination\Item\ChangeSet\ChangeSetCollectionInterface;
use DDiff\Destination\Item\ChangeSet\ChangeSetInterface;
use DDiff\Item\ItemInterface;

/**
 * Class State
 * @package DDiff\Destination
 */
class State implements StateInterface
{
    /**
     * @var bool
     */
    protected $new = false;

    /**
     * @var bool
     */
    protected $modified = false;

    /**
     * @var bool
     */
    protected $found = false;

    /**
     * @var ItemInterface
     */
    protected $sourceItem;

    /**
     * @var ItemInterface
     */
    protected $destinationItem;

    /**
     * @var ChangeSetInterface[]
     */
    protected $changes = [];

    /**
     * @var bool
     */
    protected $removed = false;

    /**
     * State constructor.
     * @param bool $new
     * @param bool $found
     * @param ItemInterface $sourceItem
     * @param ItemInterface $destinationItem
     * @param ChangeSetCollectionInterface $changes
     */
    public function __construct(
        bool $new,
        bool $found,
        ItemInterface $sourceItem,
        ItemInterface $destinationItem = null,
        ChangeSetCollectionInterface $changes
    ) {
        $this->new = $new;
        $this->found = $found;
        $this->sourceItem = $sourceItem;
        $this->destinationItem = $destinationItem;
        $this->changes = $changes;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * @return bool
     */
    public function isModified(): bool
    {
        return $this->isFound() && $this->getChanges()->hasChanges();
    }

    /**
     * @return bool
     */
    public function isFound(): bool
    {
        return $this->found;
    }

    /**
     * @return bool
     */
    public function isRemoved(): bool
    {
        return $this->removed;
    }

    /**
     *
     */
    public function setAsRemoved()
    {
        $this->removed = true;
    }

    /**
     * @return ItemInterface
     */
    public function getSourceItem(): ItemInterface
    {
        return $this->sourceItem;
    }

    /**
     * @return ItemInterface
     */
    public function getDestinationItem()
    {
        return $this->destinationItem;
    }

    /**
     * @return ChangeSetInterface[]|ChangeSetCollectionInterface
     */
    public function getChanges(): ChangeSetCollectionInterface
    {
        return $this->changes;
    }
}
