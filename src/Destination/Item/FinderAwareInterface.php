<?php

namespace DDiff\Destination\Item;

/**
 * Interface FinderAwareInterface
 * @package DDiff\Destination\Item
 */
interface FinderAwareInterface
{
    /**
     * @return FinderInterface
     */
    public function getFinder() : FinderInterface;

    /**
     * @param FinderInterface $finder
     * @return $this
     */
    public function setFinder(FinderInterface $finder);
}
