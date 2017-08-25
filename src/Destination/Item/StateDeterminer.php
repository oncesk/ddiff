<?php

namespace DDiff\Destination\Item;

use DDiff\Destination\Item\ChangeSet\Calculator;
use DDiff\Destination\Item\ChangeSet\CalculatorInterface;
use DDiff\Destination\Item\ChangeSet\EmptyChangeSetCollection;
use DDiff\Destination\Item\ChangeSet\LazyChangeSetCollection;
use DDiff\Exception\NotFountException;
use DDiff\Item\ItemInterface;

/**
 * Class StateDeterminer
 * @package DDiff\Destination\Item
 */
class StateDeterminer implements StateDeterminerInterface
{
    /**
     * @var CalculatorInterface
     */
    protected $changeSetCalculator;

    /**
     * @param ItemInterface $item
     * @param FinderInterface $finder
     * @return StateInterface
     */
    public function determine(ItemInterface $item, FinderInterface $finder): StateInterface
    {
        try {
            $destinationItem = $finder->find($item);
            $changeSetCollection = new LazyChangeSetCollection($item, $destinationItem, $this->getChangeSetCalculator());
            $state = new State(
                false,
                true,
                $item,
                $destinationItem,
                $changeSetCollection
            );
        } catch (NotFountException $e) {
            $state = new State(
                true,
                false,
                $item,
                null,
                new EmptyChangeSetCollection()
            );
        }

        return $state;
    }

    /**
     * @return CalculatorInterface
     */
    protected function getChangeSetCalculator()
    {
        if (null === $this->changeSetCalculator) {
            $this->changeSetCalculator = new Calculator();
        }
        return $this->changeSetCalculator;
    }
}
