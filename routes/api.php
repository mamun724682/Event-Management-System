<?php

use App\Controllers\Api\EventController;
use App\Router;

Router::get('/api/events', [EventController::class, 'index', 'auth']);
Router::post('/api/events/{slug}/submit-register', [EventController::class, 'register']);