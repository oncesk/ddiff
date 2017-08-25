<?php

namespace DDiff\Item\Context;

/**
 * Interface ContextInterface
 * @package DDiff\Item\Context
 */
interface ContextInterface
{
    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name) : bool;

    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function get(string $name, $default = null);

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function set(string $name, $value);

    /**
     * @return array
     */
    public function getAll() : array;
}
