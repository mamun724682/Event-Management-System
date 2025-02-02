<?php

namespace Database\migrations;

use Database\Database;

class ACreateUsersTable extends Database
{
    private string $tableName = 'users';

    public function up()
    {
        if (!$this->hasTable($this->tableName)) {
            $query = "
            CREATE TABLE IF NOT EXISTS {$this->tableName} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ";
            $this->db->exec($query);
            echo "Table `{$this->tableName}` created successfully.\n";
        }
    }

    public function down()
    {
        $this->db->exec("SET foreign_key_checks = 0;");
        $this->db->exec("DROP TABLE IF EXISTS {$this->tableName};");
        $this->db->exec("SET foreign_key_checks = 1;");
        echo "Table `{$this->tableName}` dropped successfully.\n";
    }
}