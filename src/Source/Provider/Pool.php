<?php

namespace DDiff\Source\Provider;

use DDiff\Exception\NotFountException;

/**
 * Class Pool
 * @package DDiff\Source\Provider
 */
class Pool implements PoolInterface
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers = [];

    /**
     * @param string $name
     * @return ProviderInterface
     * @throws NotFountException
     */
    public function getProvider(string $name): ProviderInterface
    {
        if ($this->hasProvider($name)) {
            return $this->providers[$name];
        }

        throw new NotFountException('Provider with name ' . $name . ' not found');
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasProvider(string $name): bool
    {
        return isset($this->providers[$name]);
    }

    /**
     * @param ProviderInterface $provider
     * @return $this
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;

        return $this;
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }
}
