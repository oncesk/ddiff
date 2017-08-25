<?php

namespace DDiff\Item;

/**
 * Class ValueAwareInterface
 * @package DDiff\Item
 */
interface ValueAwareInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value);
}
