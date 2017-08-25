<?php

namespace DDiff\Result;

use DDiff\Result\Formatter\VoidFormatter;

/**
 * Class FormatterAwareTrait
 * @package DDiff\Result
 */
trait FormatterAwareTrait
{
    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @return FormatterInterface
     */
    public function getFormatter() : FormatterInterface
    {
        if (null === $this->formatter) {
            $this->formatter = new VoidFormatter();
        }

        return $this->formatter;
    }

    /**
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }
}
