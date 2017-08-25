<?php

namespace DDiff\Model;

use DDiff\Item\Context\ContextInterface;

/**
 * Interface ConfigurableInterface
 * @package DDiff\Model
 */
interface ConfigurableInterface
{
    /**
     * @param ContextInterface $context
     */
    public function configure(ContextInterface $context);
}
