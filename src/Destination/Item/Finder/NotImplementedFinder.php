<?php

namespace DDiff\Destination\Item\Finder;

use DDiff\Destination\Item\FinderInterface;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Item\ItemInterface;

/**
 * Class NotImplementedFinder
 * @package DDiff\Destination\Item\Finder
 */
class NotImplementedFinder implements FinderInterface
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'not_implemented';
    }

    /**
     * @param ItemInterface $item
     * @return ItemInterface
     * @throws InvalidConfigurationException
     */
    public function find(ItemInterface $item): ItemInterface
    {
        throw new InvalidConfigurationException("Invalid configuration, it looks like finder not set properly");
    }
}
