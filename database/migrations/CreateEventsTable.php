<?php

namespace Database\migrations;

use Database\Database;

class CreateEventsTable extends Database
{
    public function up()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ";
        $this->db->exec($query);
        echo "Table `events` created successfully.\n";
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS events;");
        echo "Table `events` dropped successfully.\n";
    }
}