<?php

namespace Database\seeders;

use App\Models\Attendee;
use Database\Database;

class AttendeeSeeder extends Database
{
    public function run()
    {
        echo "Attendees table started seeding.\n";

        foreach (range(1, 100) as $item) {
            (new Attendee)->create([
                "event_id"   => rand(1, 100),
                "name"       => "Attendee $item",
                "email"      => "attendee{$item}@app.com",
                "phone"      => "0196714168{$item}",
                "created_at" => (new \DateTime())->format("Y-m-d H:i:s"),
                "updated_at" => (new \DateTime())->format("Y-m-d H:i:s")
            ]);
        }

        echo "Attendee table seeded successfully.\n";
    }
}