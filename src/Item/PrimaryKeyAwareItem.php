<?php

namespace DDiff\Item;

use DDiff\Database\Schema\PrimaryKeyAwareInterface;
use DDiff\Database\Schema\PrimaryKeyAwareTrait;

/**
 * Class PrimaryKeyAwareItem
 * @package DDiff\Item
 */
class PrimaryKeyAwareItem extends Item implements PrimaryKeyAwareInterface
{
    use PrimaryKeyAwareTrait;
}
