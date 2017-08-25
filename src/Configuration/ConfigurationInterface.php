<?php

namespace DDiff\Configuration;

use DDiff\Destination\Item\FinderAwareInterface;
use DDiff\Destination\Item\StateDeterminerAwareInterface;
use DDiff\Item\Context\ContextAwareInterface;
use DDiff\Result\FormatterAwareInterface;
use DDiff\Result\OutputAwareInterface;
use DDiff\Source\Provider\ProviderAwareInterface as SourceProviderInterface;

/**
 * Interface ConfigurationInterface
 * @package DDiff\Configuration
 */
interface ConfigurationInterface extends
    ContextAwareInterface,
    SourceProviderInterface,
    FormatterAwareInterface,
    OutputAwareInterface,
    StateDeterminerAwareInterface,
    FinderAwareInterface
{

}
