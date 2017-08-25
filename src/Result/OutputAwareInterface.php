<?php

namespace DDiff\Result;

/**
 * Class OutputAwareInterface
 * @package DDiff\Result
 */
interface OutputAwareInterface
{
    /**
     * @return OutputInterface
     */
    public function getOutput() : OutputInterface;

    /**
     * @param OutputInterface $output
     * @return $this
     */
    public function setOutput(OutputInterface $output);
}
