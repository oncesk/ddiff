<?php

namespace DDiff\Database\Schema;

/**
 * Class Field
 * @package DDiff\Database\Schema
 */
class Field implements FieldInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Field constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config['Field'];
    }

    /**
     * @return bool
     */
    public function isPrimaryKey(): bool
    {
        return $this->config['Key'] == 'PRI';
    }

    /**
     * @return string
     */
    public function getRawType(): string
    {
        return $this->config['Type'];
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->config['Default'];
    }
}
