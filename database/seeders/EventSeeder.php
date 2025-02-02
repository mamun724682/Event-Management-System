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
                "description" => "What is Lorem Ipsum?
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
                "date"        => (new \DateTime('2026-10-04'))->format("Y-m-d"),
                "created_at"  => (new \DateTime())->format("Y-m-d H:i:s"),
                "updated_at"  => (new \DateTime())->format("Y-m-d H:i:s")
            ]);
        }

        echo "Event table seeded successfully.\n";
    }
}