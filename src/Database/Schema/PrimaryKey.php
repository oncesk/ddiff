<?php

namespace DDiff\Database\Schema;

/**
 * Class PrimaryKey
 * @package DDiff\Database\Schema
 */
class PrimaryKey implements PrimaryKeyInterface
{
    /**
     * @var FieldCollectionInterface
     */
    protected $fields;

    /**
     * PrimaryKey constructor.
     */
    public function __construct()
    {
        $this->fields = new FieldCollection();
    }

    /**
     * @return FieldCollectionInterface
     */
    public function getFields(): FieldCollectionInterface
    {
        return $this->fields;
    }

    /**
     * @param PrimaryFieldInterface $field
     * @return $this
     */
    public function addField(PrimaryFieldInterface $field)
    {
        $this->fields->add($field);

        return $this;
    }
}
