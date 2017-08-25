<?php

namespace DDiff\Item\Metadata;

/**
 * Class Metadata
 * @package DDiff\Item\Metadata
 */
class Metadata implements MetadataInterface
{
    /**
     * @var string
     */
    protected $rawType;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $defaultValue;

    /**
     * Metadata constructor.
     * @param string $rawType
     * @param string $type
     * @param null $defaultValue
     */
    public function __construct(string $rawType, string $type, $defaultValue = null)
    {
        $this->rawType = $rawType;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getRawType(): string
    {
        return $this->rawType;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isInteger(): bool
    {
        return in_array($this->getType(), [
            'int',
            'integer',
            'double',
            'float',
            'long',
        ]);
    }

    /**
     * @return bool
     */
    public function isString(): bool
    {
        return in_array($this->getType(), [
            'string',
            'char',
            'varchar',
            'text',
            'longtext'
        ]);
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
