<?php

namespace DDiff\Destination\Item\Finder\Context;

/**
 * Class DestinationTableContextTrait
 * @package DDiff\Destination\Item\Finder\Context
 */
trait DestinationTableContextTrait
{
    /**
     * @var string
     */
    protected $destinationTable;

    /**
     * @param string $table
     * @return $this
     */
    public function setDestinationTable(string $table)
    {
        $this->destinationTable = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationTable(): string
    {
        return $this->destinationTable;
    }
}
