<?php

namespace DDiff\Destination\Item\ChangeSet;

use DDiff\Item\ItemInterface;
use DDiff\Item\ValueAwareInterface;

/**
 * Class Calculator
 * @package DDiff\Destination\Item\ChangeSet
 */
class Calculator implements CalculatorInterface
{
    /**
     * @param ItemInterface $source
     * @param ItemInterface $destination
     * @return ChangeSetInterface[]
     */
    public function calculateChangeSet(ItemInterface $source, ItemInterface $destination): array
    {
        $changes = [];

        foreach ($source->getFields() as $field) {
            if ($field instanceof ValueAwareInterface) {
                if ($destination->hasField($field->getName())) {
                    $destinationField = $destination->getField($field->getName());
                    if ($destinationField instanceof ValueAwareInterface) {
                        if ($field->getValue() != $destinationField->getValue()) {
                            $changes[] = new ChangeSet($field, $field->getValue(), $destinationField->getValue());
                        }
                    }
                }
            }
        }


        return $changes;
    }
}
