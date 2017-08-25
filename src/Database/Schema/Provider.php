<?php

namespace DDiff\Database\Schema;

use DDiff\Configuration\Database\DatabaseConfigurationInterface;
use DDiff\Database\Schema;
use DDiff\Database\SchemaInterface;

/**
 * Class Provider
 * @package DDiff\Database\Schema
 */
class Provider implements ProviderInterface
{
    /**
     * @var SchemaInterface[]
     */
    protected $schemas = [];

    /**
     * @param \PDO $pdo
     * @param DatabaseConfigurationInterface $configuration
     * @return SchemaInterface
     */
    public function getSchema(\PDO $pdo, DatabaseConfigurationInterface $configuration): SchemaInterface
    {
        $key = $this->createCacheKey($configuration);

        if (isset($this->schemas[$key])) {
            return $this->schemas[$key];
        }

        return $this->schemas[$key] = new Schema($pdo, $configuration->getDatabase());
    }

    /**
     * @param DatabaseConfigurationInterface $configuration
     * @return string
     */
    protected function createCacheKey(DatabaseConfigurationInterface $configuration)
    {
        return $configuration->getHost() . $configuration->getPort() . $configuration->getDatabase();
    }
}
