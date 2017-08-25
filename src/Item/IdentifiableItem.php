<?php

namespace DDiff\Item;

/**
 * Class IdentifiableItem
 * @package DDiff\Item
 */
class IdentifiableItem extends Item implements IdentifiableInterface
{
    /**
     * @var FieldInterface
     */
    protected $id;

    /**
     * IdentifiableItem constructor.
     * @param FieldInterface $id
     */
    public function __construct(FieldInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return FieldInterface
     */
    public function getId(): FieldInterface
    {
        return $this->id;
    }
}
