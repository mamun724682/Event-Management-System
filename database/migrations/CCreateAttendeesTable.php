<?php

namespace Database\migrations;

use Database\Database;

class CCreateAttendeesTable extends Database
{
    public function up()
    {
        $query = "
            CREATE TABLE attendees (
                id INT AUTO_INCREMENT PRIMARY KEY,
                event_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
            );
        ";
        $this->db->exec($query);
        echo "Table `attendees` created successfully.\n";
    }

    public function down()
    {
        $this->db->exec("SET foreign_key_checks = 0;");
        $this->db->exec("DROP TABLE IF EXISTS attendees;");
        $this->db->exec("SET foreign_key_checks = 1;");
        echo "Table `attendees` dropped successfully.\n";
    }
}