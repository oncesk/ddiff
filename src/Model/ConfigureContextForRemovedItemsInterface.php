<?php

namespace DDiff\Model;

use DDiff\Item\Context\ContextInterface;

/**
 * Interface ConfigureContextForRemovedItemsInterface
 * @package DDiff\Model
 */
interface ConfigureContextForRemovedItemsInterface
{
    /**
     * @param ContextInterface $context
     */
    public function configureContextForRemovedItems(ContextInterface $context);
}
