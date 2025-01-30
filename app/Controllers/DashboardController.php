<?php

namespace App\Controllers;

use App\Auth;
use App\Models\User;
use App\View;

class DashboardController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function dashboard()
    {
        echo Auth::user()['name'];
        die();
        View::renderAndEcho('auth.login');
    }
}
