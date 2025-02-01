<?php

namespace App\Controllers;

use App\View;

class DashboardController
{
    public function dashboard()
    {
        View::renderAndEcho('dashboard.home');
    }
}
