<?php

namespace DDiff\Result;

use DDiff\Destination\Item\StateInterface;
use DDiff\Item\Context\ContextInterface;
use DDiff\Model\NameAwareInterface;

/**
 * Interface FormatterInterface
 * @package DDiff\Result
 */
interface FormatterInterface extends NameAwareInterface
{
    /**
     * @param StateInterface $state
     * @param ContextInterface $context
     * @return string
     */
    public function format(StateInterface $state, ContextInterface $context);
}
