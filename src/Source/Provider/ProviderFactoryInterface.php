<?php

namespace DDiff\Source\Provider;

/**
 * Class ProviderFactoryInterface
 * @package DDiff\Source\Provider
 */
interface ProviderFactoryInterface
{
    /**
     * @return ProviderInterface
     */
    public function createSourceProvider() : ProviderInterface;
}
