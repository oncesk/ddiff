<?php

namespace DDiff\Item;

use DDiff\Item\Metadata\MetadataAwareInterface;
use DDiff\Item\Metadata\MetadataAwareTrait;

/**
 * Class Field
 * @package DDiff\Source\Item
 */
class Field implements FieldInterface, MetadataAwareInterface
{
    use MetadataAwareTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * Field constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
