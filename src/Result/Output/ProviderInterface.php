<?php

namespace DDiff\Result\Output;

use DDiff\Exception\NotFountException;
use DDiff\Result\OutputInterface;

/**
 * Interface ProviderInterface
 * @package DDiff\Result\Output
 */
interface ProviderInterface
{
    /**
     * @param string $name
     * @throws NotFountException
     * @return OutputInterface
     */
    public function getOutput(string $name) : OutputInterface;

    /**
     * @param string $name
     * @return bool
     */
    public function hasOutput(string $name) : bool;

    /**
     * @param OutputInterface $output
     * @return $this
     */
    public function addOutput(OutputInterface $output);
}
