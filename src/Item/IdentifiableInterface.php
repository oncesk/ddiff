<?php

namespace DDiff\Item;

/**
 * Interface IdentifiableInterface
 * @package DDiff\Source\Item
 */
interface IdentifiableInterface
{
    /**
     * @return FieldInterface
     */
    public function getId() : FieldInterface;
}
