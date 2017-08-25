<?php

namespace DDiff\Result;

/**
 * Interface FormatterAwareInterface
 * @package DDiff\Result
 */
interface FormatterAwareInterface
{
    /**
     * @return FormatterInterface
     */
    public function getFormatter() : FormatterInterface;

    /**
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function setFormatter(FormatterInterface $formatter);
}
