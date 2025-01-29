<?php

namespace Database\migrations;

use Database\Database;

class ACreateUsersTable extends Database
{
    public function up()
    {
        $query = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );
        ";
        $this->db->exec($query);
        echo "Table `users` created successfully.\n";
    }

    public function down()
    {
        $this->db->exec("DROP TABLE IF EXISTS users;");
        echo "Table `users` dropped successfully.\n";
    }
}