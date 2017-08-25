<?php

namespace DDiff\Configuration\Database;

/**
 * Class DatabaseConfiguration
 * @package DDiff\Configuration\Database
 */
class DatabaseConfiguration implements DatabaseConfigurationInterface
{
    /**
     * @var string
     */
    protected $host = 'localhost';

    /**
     * @var int
     */
    protected $port = 3306;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * @var string
     */
    protected $driver = 'mysql';

    /**
     * @var string
     */
    protected $database;

    /**
     * DatabaseConfiguration constructor.
     *
     * @param string $user
     * @param string $password
     * @param string $database
     * @param string $host
     * @param int $port
     * @param string $driver
     * @param string $charset
     */
    public function __construct(
        string $user,
        string $password,
        string $database,
        string $host = 'localhost',
        int $port = 3306,
        string $driver = 'mysql',
        string $charset = 'utf8'
    ) {
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->host = $host;
        $this->port = $port;
        $this->driver = $driver;
        $this->charset = $charset;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }
}
