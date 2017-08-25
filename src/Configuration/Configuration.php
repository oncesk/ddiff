<?php

namespace DDiff\Configuration;

use DDiff\Destination\Item\FinderAwareTrait;
use DDiff\Destination\Item\StateDeterminerAwareTrait;
use DDiff\Item\Context\ContextAwareTrait;
use DDiff\Result\FormatterAwareTrait;
use DDiff\Result\OutputAwareTrait;
use DDiff\Source\Provider\ProviderAwareTrait;

/**
 * Class Configuration
 * @package DDiff\Configuration
 */
class Configuration implements ConfigurationInterface
{
    use ContextAwareTrait;
    use ProviderAwareTrait;
    use FormatterAwareTrait;
    use OutputAwareTrait;
    use StateDeterminerAwareTrait;
    use FinderAwareTrait;
}
