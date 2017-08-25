<?php

namespace DDiff\Configuration\Storage;

/**
 * Class Storage
 * @package DDiff\Configuration\Storage
 */
class Storage implements StorageInterface
{
    /**
     * @var string
     */
    protected $baseDir;

    /**
     * Storage constructor.
     * @param string $baseDir
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $name
     * @param string $data
     * @return bool|int
     */
    public function save(string $name, string $data)
    {
        return file_put_contents($this->baseDir . $this->formatName($name), $data);
    }

    /**
     * @param string $name
     * @return bool|string
     */
    public function load(string $name)
    {
        $name = $this->formatName($name);
        if (file_exists($this->baseDir . $name)) {
            return file_get_contents($this->baseDir . $name);
        }

        return '';
    }

    /**
     * @param string $mask
     * @return array
     */
    public function getConfigurations(string $mask): array
    {
        return glob($this->baseDir . $mask);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function formatName(string $name)
    {
        return $name;
    }
}
