<?php

use App\Controllers\EventController;
use App\Router;

Router::get('/events', [EventController::class, 'index']);
Router::get('/events/{id}', [EventController::class, 'show']);
Router::post('/events', [EventController::class, 'store']);
Router::put('/events/{id}', [EventController::class, 'update']);
Router::delete('/events/{id}', [EventController::class, 'destroy']);