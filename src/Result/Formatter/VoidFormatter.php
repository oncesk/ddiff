<?php

namespace DDiff\Result\Formatter;

use DDiff\Destination\Item\StateInterface;
use DDiff\Item\Context\ContextInterface;
use DDiff\Result\FormatterInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class VoidFormatter
 * @package DDiff\Result\Formatter
 */
class VoidFormatter implements FormatterInterface, NullObjectInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'void';
    }


    /**
     * @param StateInterface $state
     * @param ContextInterface $context
     *
     * @return void
     */
    public function format(StateInterface $state, ContextInterface $context)
    {
        // do nothing
    }
}
