<?php

namespace DDiff\Result\Formatter;

use DDiff\Exception\NotFountException;
use DDiff\Result\FormatterInterface;

/**
 * Interface ProviderInterface
 * @package DDiff\Result\Formatter
 */
interface ProviderInterface
{
    /**
     * @param string $name
     * @throws NotFountException
     * @return FormatterInterface
     */
    public function getFormatter(string $name) : FormatterInterface;

    /**
     * @param string $name
     * @return bool
     */
    public function hasFormatter(string $name) : bool;

    /**
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function addFormatter(FormatterInterface $formatter);
}
