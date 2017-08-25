<?php

namespace DDiff\Source\Provider;

/**
 * Class ProviderAwareInterface
 * @package DDiff\Source\Provider
 */
interface ProviderAwareInterface
{
    /**
     * @return ProviderInterface
     */
    public function getSourceProvider() : ProviderInterface;

    /**
     * @param ProviderInterface $provider
     * @return $this
     */
    public function setSourceProvider(ProviderInterface $provider);
}
