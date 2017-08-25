<?php

namespace DDiff\Configuration\Database;

use DDiff\Configuration\Storage\StorageInterface;
use DDiff\Exception\InvalidConfigurationException;
use DDiff\Exception\NotFountException;

/**
 * Class DatabaseFactory
 * @package DDiff\Configuration\Database
 */
class DatabaseFactory implements DatabaseFactoryInterface
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var DatabaseConfigurationInterface[]
     */
    protected $configurations = [];

    /**
     * DatabaseFactory constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $name
     * @throws NotFountException
     * @throws InvalidConfigurationException
     * @return DatabaseConfigurationInterface
     */
    public function createConfigurationByName(string $name): DatabaseConfigurationInterface
    {
        if (isset($this->configurations[$name])) {
            return $this->configurations[$name];
        }

        $config = $this->storage->load($name);

        if (!$config) {
            throw new NotFountException('Configuration with name ' . $name . ' not found');
        }

        $json = json_decode($config, true);

        if (JSON_ERROR_NONE === json_last_error()) {
            return $this->configurations[$name] = new DatabaseConfiguration(
                $json['user'],
                $json['password'],
                $json['database'],
                $json['host'],
                $json['port'],
                $json['driver'],
                $json['charset']
            );
        }

        throw new InvalidConfigurationException('It looks like json has invalid format');
    }
}
