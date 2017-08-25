<?php

namespace DDiff\Destination\Item;

/**
 * Class StateDeterminerAwareTrait
 * @package DDiff\Destination\Item
 */
trait StateDeterminerAwareTrait
{
    /**
     * @var StateDeterminerInterface
     */
    protected $stateDeterminer;

    /**
     * @return StateDeterminerInterface
     */
    public function getStateDeterminer() : StateDeterminerInterface
    {
        if (null === $this->stateDeterminer) {
            $this->stateDeterminer = new NullStateDeterminer();
        }

        return $this->stateDeterminer;
    }

    /**
     * @param StateDeterminerInterface $determiner
     * @return $this
     */
    public function setStateDeterminer(StateDeterminerInterface $determiner)
    {
        $this->stateDeterminer = $determiner;

        return $this;
    }
}
