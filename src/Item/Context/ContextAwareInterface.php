<?php

namespace DDiff\Item\Context;

/**
 * Class ContextAwareInterface
 * @package DDiff\Item\Context
 */
interface ContextAwareInterface
{
    /**
     * @return ContextInterface
     */
    public function getContext() : ContextInterface;

    /**
     * @param ContextInterface $context
     * @return $this
     */
    public function setContext(ContextInterface $context);
}
