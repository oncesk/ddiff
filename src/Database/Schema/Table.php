<?php

namespace DDiff\Database\Schema;
use DDiff\Exception\DatabaseException;
use DDiff\Exception\NotFountException;

/**
 * Class Table
 * @package DDiff\Database\Schema
 */
class Table implements TableInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var FieldCollectionInterface
     */
    protected $fieldCollection;

    /**
     * @var PrimaryKeyInterface
     */
    protected $primaryKey;

    /**
     * Table constructor.
     * @param \PDO $pdo
     * @param string $name
     */
    public function __construct(\PDO $pdo, string $name)
    {
        $this->pdo = $pdo;
        $this->name = $name;
        $this->primaryKey = new PrimaryKey();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return FieldCollectionInterface
     */
    public function getFields(): FieldCollectionInterface
    {
        if (null === $this->fieldCollection) {
            $this->fieldCollection = $this->createFieldCollection();
        }

        return $this->fieldCollection;
    }

    /**
     * @return bool
     */
    public function hasPrimaryKey(): bool
    {
        $this->getFields();
        return $this->primaryKey->getFields()->count() > 0;
    }

    /**
     * @return PrimaryKeyInterface
     */
    public function getPrimaryKey(): PrimaryKeyInterface
    {
        $this->getFields();
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return FieldCollection
     * @throws DatabaseException
     */
    protected function createFieldCollection()
    {
        $stm = $this->pdo->prepare("SHOW FULL COLUMNS IN `$this->name`");
        if (false === $stm->execute()) {
            throw new DatabaseException('Could not execut show columns query for table ' . $this->name);
        }
        $columns = $stm->fetchAll(\PDO::FETCH_ASSOC);

        $collection = new FieldCollection();
        foreach ($columns as $column) {
            $field = $this->createField($column);
            $collection->add($field);
            if ($field instanceof PrimaryFieldInterface) {
                $this->primaryKey->addField($field);
            }
        }

        return $collection;
    }

    /**
     * @param array $column
     * @return FieldInterface
     */
    protected function createField(array $column) : FieldInterface
    {
        if ($column['Key'] === 'PRI') {
            return new PrimaryField($column);
        }
        return new Field($column);
    }
}
