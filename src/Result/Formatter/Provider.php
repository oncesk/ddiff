<?php

namespace DDiff\Result\Formatter;

use DDiff\Exception\NotFountException;
use DDiff\Result\FormatterInterface;

/**
 * Class Provider
 * @package DDiff\Result\Formatter
 */
class Provider implements ProviderInterface
{
    /**
     * @var FormatterInterface[]
     */
    protected $formatters = [];

    /**
     * @param string $name
     * @return FormatterInterface
     * @throws NotFountException
     */
    public function getFormatter(string $name): FormatterInterface
    {
        if ($this->hasFormatter($name)) {
            return $this->formatters[$name];
        }

        throw new NotFountException("Formatter with name $name not found");
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFormatter(string $name): bool
    {
        return isset($this->formatters[$name]);
    }

    /**
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function addFormatter(FormatterInterface $formatter)
    {
        $this->formatters[$formatter->getName()] = $formatter;

        return $this;
    }
}
