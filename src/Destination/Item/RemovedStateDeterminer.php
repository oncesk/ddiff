<?php

namespace DDiff\Destination\Item;

use DDiff\Destination\Item\ChangeSet\EmptyChangeSetCollection;
use DDiff\Item\ItemInterface;

/**
 * Class RemovedStateDeterminer
 * @package DDiff\Destination\Item
 */
class RemovedStateDeterminer implements StateDeterminerInterface
{
    /**
     * @var StateDeterminerInterface
     */
    protected $stateDeterminer;

    /**
     * RemovedStateDeterminer constructor.
     * @param StateDeterminerInterface $stateDeterminer
     */
    public function __construct(StateDeterminerInterface $stateDeterminer)
    {
        $this->stateDeterminer = $stateDeterminer;
    }

    /**
     * @param ItemInterface $item
     * @param FinderInterface $finder
     * @return StateInterface
     */
    public function determine(ItemInterface $item, FinderInterface $finder): StateInterface
    {
        $state = $this->stateDeterminer->determine($item, $finder);

        if ($state->isNew()) {
            $state = new State(
                false,
                false,
                $state->getSourceItem(),
                $state->getDestinationItem(),
                new EmptyChangeSetCollection()
            );
            $state->setAsRemoved();

            return $state;
        } else {
            return new State(
                false,
                false,
                $state->getSourceItem(),
                $state->getDestinationItem(),
                new EmptyChangeSetCollection()
            );
        }
    }
}
