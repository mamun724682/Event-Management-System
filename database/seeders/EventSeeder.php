<?php

namespace Database\seeders;

use App\Models\Event;
use Database\Database;

class EventSeeder extends Database
{
    public function run()
    {
        echo "Event table started seeding.\n";

        foreach (range(1, 100) as $item) {
            (new Event)->create([
                "user_id"     => rand(1, 100),
                "name"        => "Event $item",
                "slug"        => "event-$item",
                "location"    => "Dhaka",
                "capacity"    => $c = rand(100, 500),
                "total_attendees" => $c - rand(0, 99),
                "description" => "Description for Event $item",
                "date"        => (new \DateTime())->format("Y-m-d"),
                "created_at"  => (new \DateTime())->format("Y-m-d H:i:s"),
                "updated_at"  => (new \DateTime())->format("Y-m-d H:i:s")
            ]);
        }

        echo "Event table seeded successfully.\n";
    }
}