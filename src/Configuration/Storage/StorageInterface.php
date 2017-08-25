<?php

namespace DDiff\Configuration\Storage;

/**
 * Interface StorageInterface
 * @package DDiff\Configuration\Storage
 */
interface StorageInterface
{
    /**
     * @param string $name
     * @param string $data
     * @return bool
     */
    public function save(string $name, string $data);

    /**
     * @param string $name
     * @return string
     */
    public function load(string $name);

    /**
     * @param string $mask
     * @return array
     */
    public function getConfigurations(string $mask) : array;
}
