<?php

namespace DDiff\Configuration\Database;

use DDiff\Exception\InvalidConfigurationException;
use DDiff\Exception\NotFountException;

/**
 * Interface DatabaseFactoryInterface
 * @package DDiff\Configuration\Database
 */
interface DatabaseFactoryInterface
{
    /**
     * @param string $name
     * @throws NotFountException
     * @throws InvalidConfigurationException
     * @return DatabaseConfigurationInterface
     */
    public function createConfigurationByName(string $name) : DatabaseConfigurationInterface;
}
