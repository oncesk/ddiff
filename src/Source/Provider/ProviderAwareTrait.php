<?php

namespace DDiff\Source\Provider;

/**
 * Class ProviderAwareTrait
 * @package DDiff\Source\Provider
 */
trait ProviderAwareTrait
{
    /**
     * @var ProviderInterface
     */
    protected $sourceProvider;

    /**
     * @return ProviderInterface
     */
    public function getSourceProvider() : ProviderInterface
    {
        return $this->sourceProvider;
    }

    /**
     * @param ProviderInterface $provider
     * @return $this
     */
    public function setSourceProvider(ProviderInterface $provider)
    {
        $this->sourceProvider = $provider;

        return $this;
    }
}
