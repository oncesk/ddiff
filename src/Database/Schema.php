<?php

namespace DDiff\Database;

use DDiff\Database\Schema\TableCollection;
use DDiff\Database\Schema\TableCollectionInterface;

/**
 * Class Schema
 * @package DDiff\Database
 */
class Schema implements SchemaInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var TableCollectionInterface
     */
    protected $tableCollection;

    /**
     * Schema constructor.
     * @param \PDO $pdo
     * @param string $database
     */
    public function __construct(\PDO $pdo, string $database)
    {
        $this->pdo = $pdo;
        $this->database = $database;
        $this->tableCollection = new TableCollection($pdo);
    }

    /**
     * @return string
     */
    public function getDatabaseName(): string
    {
        return $this->database;
    }

    /**
     * @return TableCollectionInterface
     */
    public function getTables(): TableCollectionInterface
    {
        return $this->tableCollection;
    }
}
