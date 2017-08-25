<?php

namespace DDiff\Database;

use DDiff\Configuration\Database\DatabaseConfigurationInterface;

/**
 * Interface PdoProviderInterface
 * @package DDiff\Database
 */
interface PdoProviderInterface
{
    /**
     * @param DatabaseConfigurationInterface $configuration
     * @return \PDO
     */
    public function getPdoInstance(DatabaseConfigurationInterface $configuration);
}
