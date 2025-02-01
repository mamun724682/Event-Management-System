<?php

namespace App\Controllers;

use App\Auth;
use App\Enums\EventFiltersEnum;
use App\Services\EventService;
use App\View;

class AttendeeController
{
    public function index()
    {
        $eventService = new EventService();
        $events = $eventService->getAll(queryParameters: [
            "perPage"                        => 100,
            EventFiltersEnum::USER_ID->value => Auth::id(),
        ]);
        View::renderAndEcho('dashboard.attendees.index', [
            'events' => $events['data'],
        ]);
    }
}
