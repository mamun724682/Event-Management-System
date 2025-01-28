<?php

use App\Models\Event;
use Database\Database;

class EventSeeder extends Database
{
    public function run()
    {
        foreach (range(1, 100) as $item) {
            (new Event)->create([
                "name"        => "Event $item",
                "description" => "Description for Event $item",
                "created_at"  => (new \DateTime())->format("Y-m-d H:i:s"),
                "updated_at"  => (new \DateTime())->format("Y-m-d H:i:s")
            ]);
        }

        echo "Event table seeded successfully.\n";
    }
}