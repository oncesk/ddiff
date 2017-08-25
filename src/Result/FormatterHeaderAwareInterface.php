<?php

namespace DDiff\Result;

use DDiff\Configuration\ConfigurationInterface;

/**
 * Interface FormatterHeaderAwareInterface
 * @package DDiff\Result
 */
interface FormatterHeaderAwareInterface
{
    /**
     * @param ConfigurationInterface $configuration
     * @return string|null
     */
    public function formatHeader(ConfigurationInterface $configuration);
}
