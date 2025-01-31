<?php

namespace App\Models;

use App\View;
use Database\Database;
use PDO;

abstract class Model extends Database
{
    protected $table;
    protected $whereClauses = [];
    protected $bindings = [];
    protected $orderByClause = '';

    public function where($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        // Use unique named placeholders for each where clause
        $placeholder = ':' . str_replace('.', '_', $column) . '_' . count($this->whereClauses);

        $this->whereClauses[] = "$column $operator $placeholder";
        $this->bindings[$placeholder] = $value;

        return $this;
    }

    public function orderBy($direction = 'ASC', $column = 'id')
    {
        $this->orderByClause = "ORDER BY $column $direction";
        return $this;
    }

    private function buildWhere()
    {
        if (empty($this->whereClauses)) {
            return '';
        }

        return ' WHERE ' . implode(' AND ', $this->whereClauses);
    }

    public function get()
    {
        try {
            $query = "SELECT * FROM {$this->table}" . $this->buildWhere() . " {$this->orderByClause}";
            $stmt = $this->db->prepare($query);
            $stmt->execute($this->bindings);

            // Reset where clauses after execution
            $this->resetQuery();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching data: " . $e->getMessage());
        }
    }

    public function paginate($perPage = 25, $currentPage = 1)
    {
        try {
            $offset = ($currentPage - 1) * $perPage;

            // Build the WHERE clause and update bindings with named parameters
            $whereClause = $this->buildWhere(true);

            // Final SQL query
            $query = "SELECT * FROM {$this->table} {$whereClause} {$this->orderByClause} LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);

            // Bind WHERE parameters using named placeholders
            foreach ($this->bindings as $key => $value) {
                $stmt->bindValue($key, $value); // $key already includes the colon prefix, e.g., ":status"
            }

            // Bind LIMIT and OFFSET as integers
            $stmt->bindValue(':limit', (int)$perPage, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Reset the state for subsequent queries
            $this->resetQuery();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching paginated data: " . $e->getMessage());
        }
    }

    public function find($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching data by id: " . $e->getMessage());
        }
    }

    public function findOrFail($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$data) {
                View::renderAndEcho('errors.error', [
                    'code'    => 404,
                    'message' => "Data not found for id: " . $id,
                    'trace'   => null
                ]);
            }
            return $data;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching data by id: " . $e->getMessage());
        }
    }

    public function first()
    {
        try {
            $query = "SELECT * FROM {$this->table}" . $this->buildWhere();
            $stmt = $this->db->prepare($query);
            $stmt->execute($this->bindings);

            $this->resetQuery();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching first data: " . $e->getMessage());
        }
    }

    public function create($data)
    {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));

            $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
            $stmt->execute(array_values($data));
            return $this->find($this->db->lastInsertId());
        } catch (\Exception $e) {
            throw new \Exception("Error creating data: " . $e->getMessage());
        }
    }

    public function update(array $data, $id = null)
    {
        try {
            if ($id) {
                $this->resetQuery();
                $this->where('id', $id);
            }

            $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
            $query = "UPDATE {$this->table} SET $setClause" . $this->buildWhere();
            $stmt = $this->db->prepare($query);
            $stmt->execute(array_merge($data, $this->bindings));

            $this->resetQuery();
            return $this->find($stmt->rowCount());
        } catch (\Exception $e) {
            throw new \Exception("Error updating data: " . $e->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            if ($id) {
                $this->resetQuery();
                $this->where('id', $id);
            }

            $query = "DELETE FROM {$this->table}" . $this->buildWhere();
            $stmt = $this->db->prepare($query);
            $stmt->execute($this->bindings);

            $this->resetQuery();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            throw new \Exception("Error deleting data: " . $e->getMessage());
        }
    }

    protected function resetQuery(): void
    {
        $this->whereClauses = [];
        $this->bindings = [];
        $this->orderByClause = '';
    }
}