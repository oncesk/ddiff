<?php

namespace DDiff\Destination\Item\ChangeSet;

use DDiff\Item\FieldInterface;
use DDiff\Item\ValueAwareInterface;

/**
 * Class ChangeSet
 * @package DDiff\Destination\Item\ChangeSet
 */
class ChangeSet implements ChangeSetInterface
{
    /**
     * @var FieldInterface|ValueAwareInterface
     */
    protected $field;

    /**
     * @var mixed
     */
    protected $was;

    /**
     * @var mixed
     */
    protected $became;

    /**
     * ChangeSet constructor.
     * @param FieldInterface $field
     * @param $was
     * @param $became
     */
    public function __construct(FieldInterface $field, $was, $became)
    {
        $this->field = $field;
        $this->was = $was;
        $this->became = $became;
    }

    /**
     * @return FieldInterface
     */
    public function getField(): FieldInterface
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function was()
    {
        return $this->was;
    }

    /**
     * @return mixed
     */
    public function became()
    {
        return $this->became;
    }
}
