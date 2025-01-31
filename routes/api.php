<?php

use App\Controllers\Api\EventController;
use App\Router;

Router::get('/api/events', [EventController::class, 'index', 'auth']);