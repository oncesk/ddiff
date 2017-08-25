<?php

namespace DDiff\Source\Provider;

use DDiff\Exception\NotFountException;

/**
 * Interface PoolInterface
 * @package DDiff\Source\Provider
 */
interface PoolInterface
{
    /**
     * @param string $name
     * @throws NotFountException
     * @return ProviderInterface
     */
    public function getProvider(string $name) : ProviderInterface;

    /**
     * @param string $name
     * @return bool
     */
    public function hasProvider(string $name) : bool;

    /**
     * @param ProviderInterface $provider
     * @return $this
     */
    public function addProvider(ProviderInterface $provider);

    /**
     * @return ProviderInterface[]
     */
    public function getProviders() : array;
}
