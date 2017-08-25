<?php

namespace DDiff\Destination\Item\ChangeSet;

use DDiff\Item\ItemInterface;

/**
 * Class CalculatorInterface
 * @package DDiff\Destination\Item\ChangeSet
 */
interface CalculatorInterface
{
    /**
     * @param ItemInterface $source
     * @param ItemInterface $destination
     * @return ChangeSetInterface[]
     */
    public function calculateChangeSet(ItemInterface $source, ItemInterface $destination) : array;
}
