<?php

namespace DDiff\Destination\Item;

use DDiff\Item\ItemInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class NullStateDeterminer
 * @package DDiff\Destination\Item
 */
class NullStateDeterminer implements StateDeterminerInterface, NullObjectInterface
{
    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * @param ItemInterface $item
     * @param FinderInterface $finder
     * @return StateInterface
     */
    public function determine(ItemInterface $item, FinderInterface $finder): StateInterface
    {
        if (null === $this->state) {
            $this->state = new NullObjectState();
        }

        return $this->state;
    }
}
