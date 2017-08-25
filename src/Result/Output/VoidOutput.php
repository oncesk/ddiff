<?php

namespace DDiff\Result\Output;

use DDiff\Destination\Item\StateInterface;
use DDiff\Result\FormatterInterface;
use DDiff\Result\OutputInterface;
use DDiff\Stub\NullObjectInterface;

/**
 * Class VoidOutput
 * @package DDiff\Result\Output
 */
class VoidOutput implements OutputInterface, NullObjectInterface
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
     * @param FormatterInterface $formatter
     *
     * @return void
     */
    public function write(StateInterface $state, FormatterInterface $formatter)
    {
        // do nothing
    }
}
