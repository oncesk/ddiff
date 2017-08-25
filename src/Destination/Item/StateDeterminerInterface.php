<?php

namespace DDiff\Destination\Item;

use DDiff\Item\ItemInterface;

/**
 * Interface StateResolverInterface
 * @package DDiff\Destination
 */
interface StateDeterminerInterface
{
    /**
     * @param ItemInterface $item
     * @param FinderInterface $finder
     *
     * @return StateInterface
     */
    public function determine(ItemInterface $item, FinderInterface $finder) : StateInterface;
}
