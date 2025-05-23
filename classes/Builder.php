<?php

declare(strict_types=1);

class Builder
{
    private static $instance;

    private $queryType;
    private $table;
    private $columns = [];
    private $values = [];
    private $setClauses = [];
    private $whereClauses = [];
    private $limit;
    private $params = [];

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function reset()
    {
        $this->queryType = null;
        $this->table = null;
        $this->columns = [];
        $this->values = [];
        $this->setClauses = [];
        $this->whereClauses = [];
        $this->limit = null;
        $this->params = [];
    }

    public function table(string $tableName): self
    {
        $this->table = $tableName;
        return $this;
    }

    public function select(array $columns = ['*']): self
    {
        $this->reset();
        $this->queryType = 'SELECT';
        $this->columns = $columns;
        return $this;
    }

    public function insert(array $data): self
    {
        $this->reset();
        $this->queryType = 'INSERT';
        $this->columns = array_keys($data);
        $this->values = array_values($data);
        $this->params = $this->values;
        return $this;
    }

    public function update(array $data): self
    {
        $this->reset();
        $this->queryType = 'UPDATE';
        foreach ($data as $column => $value) {
            $this->setClauses[] = "$column = ?";
            $this->params[] = $value;
        }
        return $this;
    }

    public function delete(): self
    {
        $this->reset();
        $this->queryType = 'DELETE';
        return $this;
    }

    public function where(string $condition, $value = null): self
    {
        $this->whereClauses[] = $condition;
        if ($value !== null) {
            $this->params[] = $value;
        }
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function build(): string
    {
        if (!$this->queryType) {
            throw new Exception('Query type (select, insert, update, delete) is not set.');
        }
        if (!$this->table) {
            throw new Exception('Table name is not set.');
        }


        switch ($this->queryType) {
            case 'SELECT':
                $columns = implode(', ', $this->columns);
                $sql = "SELECT $columns FROM $this->table";
                break;

            case 'INSERT':
                $cols = implode(', ', $this->columns);
                $placeholders = rtrim(str_repeat('?, ', count($this->values)), ', ');
                $sql = "INSERT INTO $this->table ($cols) VALUES ($placeholders)";
                break;

            case 'UPDATE':
                $sql = "UPDATE $this->table SET " . implode(', ', $this->setClauses);
                break;

            case 'DELETE':
                $sql = "DELETE FROM $this->table";
                break;

            default:
                throw new Exception('Unsupported query type.');
        }

        if (!empty($this->whereClauses)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereClauses);
        }

        if ($this->limit !== null && $this->queryType !== 'INSERT') {
            $sql .= ' LIMIT ' . $this->limit;
        }

        return $sql;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
