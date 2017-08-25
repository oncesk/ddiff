<?php

namespace DDiff\Destination\Item;

use DDiff\Exception\InvalidConfigurationException;
use DDiff\Exception\NotFountException;
use DDiff\Item\ItemInterface;
use DDiff\Model\NameAwareInterface;

/**
 * Interface FinderInterface
 * @package DDiff\Destination
 */
interface FinderInterface extends NameAwareInterface
{
    /**
     * Perform some initialization
     *
     * @return void
     */
    public function init();

    /**
     * @param ItemInterface $item
     * @throws NotFountException
     * @throws InvalidConfigurationException
     * @return ItemInterface
     */
    public function find(ItemInterface $item) : ItemInterface;
}
