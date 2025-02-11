<?php

namespace Database;

use PDO;

class Database
{
    protected $db;

    public function __construct()
    {
        try {
            $config = require __DIR__ . '/../config/database.php';
            $dbConfig = $config['mysql'];

            $this->db = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4",
                $dbConfig['username'],
                $dbConfig['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    public function hasTable(string $tableName): bool
    {
        $query = "SHOW TABLES LIKE :table";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':table', $tableName, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}