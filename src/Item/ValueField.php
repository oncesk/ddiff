<?php

namespace DDiff\Item;

/**
 * Class ValueItem
 * @package DDiff\Source\Item
 */
class ValueField extends Field implements ValueAwareInterface
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * ValueItem constructor.
     * @param string $name
     * @param null $value
     */
    public function __construct(string $name, $value = null)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
