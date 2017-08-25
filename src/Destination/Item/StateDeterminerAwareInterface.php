<?php

namespace DDiff\Destination\Item;

/**
 * Interface StateDeterminerAwareInterface
 * @package DDiff\Destination\Item
 */
interface StateDeterminerAwareInterface
{
    /**
     * @return StateDeterminerInterface
     */
    public function getStateDeterminer() : StateDeterminerInterface;

    /**
     * @param StateDeterminerInterface $determiner
     * @return $this
     */
    public function setStateDeterminer(StateDeterminerInterface $determiner);
}
