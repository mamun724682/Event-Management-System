<?php

use App\Controllers\AttendeeController;
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

// Event register
Router::get('/events/{slug}/register', [EventController::class, 'showRegister']);

/**
 * Auth routes
 */
Router::get('/dashboard', [DashboardController::class, 'dashboard', 'auth']);
Router::get('/logout', [AuthController::class, 'logout', 'auth']);

// Events
Router::get('/events', [EventController::class, 'index', 'auth']);
Router::get('/events/create', [EventController::class, 'create', 'auth']);
Router::post('/events/store', [EventController::class, 'store', 'auth']);
Router::get('/events/{id}/edit', [EventController::class, 'edit', 'auth']);
Router::post('/events/{id}/update', [EventController::class, 'update', 'auth']);
Router::get('/events/{id}/delete', [EventController::class, 'destroy', 'auth']);
Router::get('/events/{id}/export', [EventController::class, 'export', 'auth']);

// Attendees
Router::get('/attendees', [AttendeeController::class, 'index', 'auth']);
