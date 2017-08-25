<?php

namespace DDiff\Result;

use DDiff\Destination\Item\StateInterface;
use DDiff\Model\NameAwareInterface;

/**
 * Interface OutputInterface
 * @package DDiff\Result
 */
interface OutputInterface extends NameAwareInterface
{
    /**
     * @param StateInterface $state
     * @param FormatterInterface $formatter
     */
    public function write(StateInterface $state, FormatterInterface $formatter);
}
