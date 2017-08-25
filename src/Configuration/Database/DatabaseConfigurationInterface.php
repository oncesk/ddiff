<?php

namespace DDiff\Configuration\Database;

/**
 * Interface DatabaseConfigurationInterface
 * @package DDiff\Configuration\Database
 */
interface DatabaseConfigurationInterface
{
    /**
     * @return string
     */
    public function getHost() : string;

    /**
     * @return int
     */
    public function getPort() : int;

    /**
     * @return string
     */
    public function getUser() : string;

    /**
     * @return string
     */
    public function getPassword() : string;

    /**
     * @return string
     */
    public function getCharset() : string;

    /**
     * @return string
     */
    public function getDriver() : string;

    /**
     * @return string
     */
    public function getDatabase() : string;
}
