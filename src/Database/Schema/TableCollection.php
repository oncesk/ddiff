<?php

namespace DDiff\Database\Schema;

use DDiff\Exception\DatabaseException;
use DDiff\Exception\NotFountException;

/**
 * Class TableCollection
 * @package DDiff\Database\Schema
 */
class TableCollection implements TableCollectionInterface
{
    /**
     * @var TableInterface[]
     */
    protected $tables;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * TableCollection constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->tables);
    }

    /**
     * @return TableInterface[]
     */
    public function getTables(): array
    {
        if (null === $this->tables) {
            $this->fetch();
        }
        return $this->tables;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTable(string $name): bool
    {
        if (null === $this->tables) {
            $this->fetch();
        }

        return isset($this->tables[$name]);
    }

    /**
     * @param string $name
     * @return TableInterface
     * @throws NotFountException
     */
    public function getTable(string $name): TableInterface
    {
        if (null === $this->tables) {
            $this->fetch();
        }

        if ($this->hasTable($name)) {
            return $this->tables[$name];
        }

        throw new NotFountException("Table $name not found");
    }

    protected function fetch()
    {
        $stm = $this->pdo->prepare("SHOW tables;");
        if (false === $stm->execute()) {
            throw new DatabaseException('Could not execute show tables query');
        }

        $tables = $stm->fetchAll(\PDO::FETCH_COLUMN);

        $this->tables = [];
        foreach ($tables as $table) {
            $this->tables[$table] = new Table($this->pdo, $table);
        }
    }
}
