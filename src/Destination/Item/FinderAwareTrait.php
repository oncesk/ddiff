<?php

namespace DDiff\Destination\Item;

use DDiff\Destination\Item\Finder\NotImplementedFinder;

/**
 * Class FinderAwareTrait
 * @package DDiff\Destination\Item
 */
trait FinderAwareTrait
{
    /**
     * @var FinderInterface
     */
    protected $finder;

    /**
     * @return FinderInterface
     */
    public function getFinder() : FinderInterface
    {
        if (null === $this->finder) {
            $this->finder = new NotImplementedFinder();
        }

        return $this->finder;
    }

    /**
     * @param FinderInterface $finder
     * @return $this
     */
    public function setFinder(FinderInterface $finder)
    {
        $this->finder = $finder;

        return $this;
    }
}
