<?php

namespace DDiff\Destination\Item\Finder\Context;

/**
 * Interface DestinationTableContextInterface
 * @package DDiff\Destination\Item\Finder\Context
 */
interface DestinationTableContextInterface
{
    /**
     * @return string
     */
    public function getDestinationTable() : string;

    /**
     * @param string $table
     * @return $this
     */
    public function setDestinationTable(string $table);
}
