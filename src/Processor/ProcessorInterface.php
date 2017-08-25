<?php

namespace DDiff\Processor;

use DDiff\Configuration\ConfigurationInterface;
use DDiff\Model\NameAwareInterface;

/**
 * Class ProcessorInterface
 * @package DDiff\Processor
 */
interface ProcessorInterface extends NameAwareInterface
{
    /**
     * @param ConfigurationInterface $configuration
     */
    public function process(ConfigurationInterface $configuration);
}
