<?php

namespace Database\migrations;

use Database\Database;

class BCreateEventsTable extends Database
{
    public function up()
    {
        $query = "
            CREATE TABLE events (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                description TEXT,
                date DATE NOT NULL,
                location VARCHAR(255),
                capacity INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
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