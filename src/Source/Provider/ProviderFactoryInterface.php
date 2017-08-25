<?php

namespace DDiff\Source\Provider;

use DDiff\Item\Context\ContextInterface;

/**
 * Class ProviderFactoryInterface
 * @package DDiff\Source\Provider
 */
interface ProviderFactoryInterface
{
    /**
     * @param ContextInterface $context
     * @return ProviderInterface
     */
    public function createSourceProvider(ContextInterface $context) : ProviderInterface;
}
