<?php

namespace App\Controllers;

use App\Auth;
use App\Enums\AttendeeFieldsEnum;
use App\Enums\EventFieldsEnum;
use App\Models\Attendee;
use App\Models\Event;
use App\View;

class DashboardController
{
    public function dashboard()
    {
        $totalEvents = (new Event())->where(EventFieldsEnum::USER_ID->value, Auth::id())->getTotalCount();
        $totalAttendees = (new Attendee())->where(AttendeeFieldsEnum::USER_ID->value, Auth::id())->getTotalCount();
        View::renderAndEcho('dashboard.home', [
            'totalEvents'    => $totalEvents,
            'totalAttendees' => $totalAttendees
        ]);
    }
}
