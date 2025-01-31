<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\EventController;
use App\Router;

/**
 * Guest Routes
 */
Router::get('/', [AuthController::class, 'showLogin', 'guest']);
Router::post('/login', [AuthController::class, 'login', 'guest']);
Router::get('/register', [AuthController::class, 'showRegister', 'guest']);
Router::post('/register', [AuthController::class, 'register', 'guest']);

/**
 * Auth routes
 */
Router::get('/dashboard', [DashboardController::class, 'dashboard', 'auth']);
Router::post('/logout', [AuthController::class, 'logout', 'auth']);

// Events
Router::get('/events', [EventController::class, 'index', 'auth']);
