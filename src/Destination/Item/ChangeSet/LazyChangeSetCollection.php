<?php

namespace DDiff\Destination\Item\ChangeSet;

use DDiff\Item\ItemInterface;

/**
 * Class LazyChangeSetCollection
 * @package DDiff\Destination\Item\ChangeSet
 */
class LazyChangeSetCollection implements ChangeSetCollectionInterface
{
    /**
     * @var ChangeSetInterface[]
     */
    protected $changes;

    /**
     * @var ItemInterface
     */
    protected $source;

    /**
     * @var ItemInterface
     */
    protected $destination;

    /**
     * @var CalculatorInterface
     */
    protected $calculator;

    /**
     * LazyChangeSetCollection constructor.
     * @param ItemInterface $source
     * @param ItemInterface $destination
     * @param CalculatorInterface $calculator
     */
    public function __construct(ItemInterface $source, ItemInterface $destination, CalculatorInterface $calculator)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->calculator = $calculator;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        if (null === $this->changes) {
            $this->changes = $this->calculate();
        }

        return new \ArrayIterator($this->changes);
    }

    /**
     * @return ChangeSetInterface[]
     */
    public function getChanges(): array
    {
        if (null === $this->changes) {
            $this->changes = $this->calculate();
        }

        return $this->changes;
    }

    public function hasChanges(): bool
    {
        if (null === $this->changes) {
            $this->changes = $this->calculate();
        }

        return !empty($this->changes);
    }


    /**
     * @return ChangeSetInterface[]
     */
    protected function calculate()
    {
        return $this->calculator->calculateChangeSet($this->source, $this->destination);
    }
}
