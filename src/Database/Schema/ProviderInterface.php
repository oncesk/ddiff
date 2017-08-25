<?php

namespace DDiff\Database\Schema;

use DDiff\Configuration\Database\DatabaseConfigurationInterface;
use DDiff\Database\SchemaInterface;

/**
 * Interface ProviderInterface
 * @package DDiff\Database\Schema
 */
interface ProviderInterface
{
    /**
     * @param \PDO $pdo
     * @param DatabaseConfigurationInterface $configuration
     * @return SchemaInterface
     */
    public function getSchema(\PDO $pdo, DatabaseConfigurationInterface $configuration) : SchemaInterface;
}
