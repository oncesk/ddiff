<?php

namespace DDiff\Database;

use DDiff\Configuration\Database\DatabaseConfigurationInterface;

/**
 * Class PdoProvider
 * @package DDiff\Database
 */
class PdoProvider implements PdoProviderInterface
{
    /**
     * @var \PDO
     */
    protected $pdoCache = [];

    /**
     * @param DatabaseConfigurationInterface $configuration
     *
     * @return \PDO
     */
    public function getPdoInstance(DatabaseConfigurationInterface $configuration)
    {
        $cacheKey = $this->createCacheKey($configuration);

        if (isset($this->pdoCache[$cacheKey])) {
            return $this->pdoCache[$cacheKey];
        }

        return $this->pdoCache[$cacheKey] = new \PDO(
            sprintf(
                "%s:host=%s;dbname=%s;charset=%s;port=%s",
                $configuration->getDriver(),
                $configuration->getHost(),
                $configuration->getDatabase(),
                $configuration->getCharset(),
                $configuration->getPort()
            ),
            $configuration->getUser(),
            $configuration->getPassword()
        );
    }

    /**
     * @param DatabaseConfigurationInterface $configuration
     * @return string
     */
    protected function createCacheKey(DatabaseConfigurationInterface $configuration)
    {
        return $configuration->getHost() . $configuration->getDatabase() . $configuration->getDriver();
    }
}
