<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Attendee;
use App\Models\Event;
use App\View;

class DashboardController
{
    public function dashboard()
    {
        $totalEvents = (new Event())->where('user_id', Auth::id())->getTotalCount();
        $totalAttendees = (new Attendee())->where('user_id', Auth::id())->getTotalCount();
        View::renderAndEcho('dashboard.home', [
            'totalEvents'    => $totalEvents,
            'totalAttendees' => $totalAttendees
        ]);
    }
}
