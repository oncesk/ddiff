<?php

namespace DDiff\Destination\Item;

use DDiff\Exception\DDiffException;
use DDiff\Item\Context\ContextInterface;

/**
 * Interface FinderFactoryInterface
 * @package DDiff\Destination\Item
 */
interface FinderFactoryInterface
{
    /**
     * @param ContextInterface $context
     * @throws DDiffException
     * @return FinderInterface
     */
    public function createDestinationFinder(ContextInterface $context) : FinderInterface;
}
