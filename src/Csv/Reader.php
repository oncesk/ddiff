<?php

namespace DDiff\Csv;

use DDiff\Exception\DDiffException;

/**
 * Class Reader
 * @package DDiff\Csv
 */
class Reader implements ReaderInterface
{
    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var string
     */
    protected $delimiter = ',';

    /**
     * @var array
     */
    protected $fields;

    /**
     * Reader constructor.
     * @param string $file
     * @throws DDiffException
     */
    public function __construct(string $file)
    {
        if (!file_exists($file) || !is_readable($file)) {
            throw new DDiffException('File not found or it is not readable');
        }

        $this->resource = fopen($file, 'r');

        if (false === $this->resource) {
            throw new DDiffException('Could not open csv file');
        }

        $this->fields = $this->readLine();
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return feof($this->resource);
    }

    /**
     * @return array
     */
    public function getFieldNames(): array
    {
        return $this->fields;
    }

    /**
     * @param string $delimiter
     * @return ReaderInterface
     */
    public function setDelimiter(string $delimiter): ReaderInterface
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return array
     * @throws DDiffException
     */
    public function read(): array
    {
        $values = $this->readLine();

        if (false === $values) {
            throw new DDiffException('It looks like empty line in csv file or end of file');
        }

        return array_combine($this->getFieldNames(), $values);
    }

    public function __destruct()
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }

    /**
     * @return array
     * @throws DDiffException
     */
    protected function readLine()
    {
        if (is_resource($this->resource)) {
            return fgetcsv($this->resource, null, $this->delimiter);
        }

        throw new DDiffException('Resource is closed');
    }
}
