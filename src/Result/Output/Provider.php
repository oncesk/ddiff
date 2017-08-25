<?php

namespace DDiff\Result\Output;

use DDiff\Exception\NotFountException;
use DDiff\Result\OutputInterface;

/**
 * Class Provider
 * @package DDiff\Result\Output
 */
class Provider implements ProviderInterface
{
    /**
     * @var OutputInterface[]
     */
    protected $outputList = [];

    /**
     * @param string $name
     * @return OutputInterface
     * @throws NotFountException
     */
    public function getOutput(string $name): OutputInterface
    {
        if ($this->hasOutput($name)) {
            return $this->outputList[$name];
        }

        throw new NotFountException("Output with name $name not found");
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOutput(string $name): bool
    {
        return isset($this->outputList[$name]);
    }

    /**
     * @param OutputInterface $output
     * @return $this
     */
    public function addOutput(OutputInterface $output)
    {
        $this->outputList[$output->getName()] = $output;

        return $this;
    }
}
