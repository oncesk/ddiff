<?php

namespace DDiff\Destination\Item;

use DDiff\Exception\DDiffException;

/**
 * Interface FinderFactoryInterface
 * @package DDiff\Destination\Item
 */
interface FinderFactoryInterface
{
    /**
     * @throws DDiffException
     * @return FinderInterface
     */
    public function createDestinationFinder() : FinderInterface;
}
