<?php

namespace DDiff\Result;

use DDiff\Result\Output\VoidOutput;

/**
 * Class OutputAwareTrait
 * @package DDiff\Result
 */
trait OutputAwareTrait
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @return OutputInterface
     */
    public function getOutput() : OutputInterface
    {
        if (null === $this->output) {
            $this->output = new VoidOutput();
        }

        return $this->output;
    }

    /**
     * @param OutputInterface $output
     * @return $this
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }
}
