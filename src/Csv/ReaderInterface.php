<?php

namespace DDiff\Csv;

/**
 * Class ReaderInterface
 * @package DDiff\Csv
 */
interface ReaderInterface
{
    /**
     * @return bool
     */
    public function eof() : bool;

    /**
     * @return array
     */
    public function getFieldNames() : array;

    /**
     * @param string $delimiter
     * @return ReaderInterface
     */
    public function setDelimiter(string $delimiter) : ReaderInterface;

    /**
     * Associative array
     *
     * @return array
     */
    public function read() : array;
}
