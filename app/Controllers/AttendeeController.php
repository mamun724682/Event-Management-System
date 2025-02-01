<?php

namespace App\Controllers;

use App\Auth;
use App\Enums\AttendeeFiltersEnum;
use App\Enums\EventFiltersEnum;
use App\Models\Event;
use App\Requests\Request;
use App\Response;
use App\Services\AttendeeService;
use App\Services\EventService;
use App\View;

class AttendeeController
{
    private AttendeeService $attendeeService;

    public function __construct()
    {
        $this->attendeeService = new AttendeeService();
    }

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
