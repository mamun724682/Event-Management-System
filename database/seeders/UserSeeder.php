<?php

namespace Database\seeders;

use App\Models\User;
use Database\Database;

class UserSeeder extends Database
{
    public function run()
    {
        echo "User table started seeding.\n";

        (new User())->create([
            "name"       => "Admin",
            "email"      => "admin@app.com",
            "password"   => password_hash(123456, PASSWORD_BCRYPT),
            "created_at" => (new \DateTime())->format("Y-m-d H:i:s"),
            "updated_at" => (new \DateTime())->format("Y-m-d H:i:s")
        ]);

        foreach (range(1, 100) as $item) {
            (new User())->create([
                "name"       => "Name $item",
                "email"      => "user{$item}@app.com",
                "password"   => password_hash(123456, PASSWORD_BCRYPT),
                "created_at" => (new \DateTime())->format("Y-m-d H:i:s"),
                "updated_at" => (new \DateTime())->format("Y-m-d H:i:s")
            ]);
        }

        echo "User table seeded successfully.\n";
    }
}