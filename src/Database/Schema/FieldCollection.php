<?php

namespace DDiff\Database\Schema;
use DDiff\Exception\NotFountException;
use Traversable;

/**
 * Class FieldCollection
 * @package DDiff\Database\Schema
 */
class FieldCollection implements FieldCollectionInterface
{
    /**
     * @var FieldInterface[]
     */
    protected $fields = [];

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->fields);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->fields);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->fields[$name]);
    }

    /**
     * @param string $name
     * @return FieldInterface
     * @throws NotFountException
     */
    public function get(string $name): FieldInterface
    {
        if ($this->has($name)) {
            return $this->fields[$name];
        }

        throw new NotFountException('Field ' . $name . ' not found in table');
    }

    /**
     * @param FieldInterface $field
     * @return $this
     */
    public function add(FieldInterface $field)
    {
        $this->fields[$field->getName()] = $field;

        return $this;
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
