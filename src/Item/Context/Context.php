<?php

namespace DDiff\Item\Context;

/**
 * Class Context
 * @package DDiff\Item\Context
 */
class Context implements ContextInterface
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Context constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->parameters[$name]);
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function get(string $name, $default = null)
    {
        if ($this->has($name)) {
            return $this->parameters[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function set(string $name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->parameters;
    }
}
