<?php

namespace Database\migrations;

use Database\Database;

class BCreateEventsTable extends Database
{
    private string $tableName = 'events';

    public function up()
    {
        if (!$this->hasTable($this->tableName)){
            $query = "
            CREATE TABLE {$this->tableName} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                description TEXT,
                date DATE NOT NULL,
                location VARCHAR(255),
                capacity INT NOT NULL,
                total_attendees INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
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