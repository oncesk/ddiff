<?php

namespace DDiff\Item\Context;

/**
 * Class ContextAwareTrait
 * @package DDiff\Item\Context
 */
trait ContextAwareTrait
{
    /**
     * @var ContextInterface
     */
    protected $context;

    /**
     * @return ContextInterface
     */
    public function getContext() : ContextInterface
    {
        if (null === $this->context) {
            $this->context = new Context();
        }

        return $this->context;
    }

    /**
     * @param ContextInterface $context
     * @return $this
     */
    public function setContext(ContextInterface $context)
    {
        $this->context = $context;

        return $this;
    }
}
