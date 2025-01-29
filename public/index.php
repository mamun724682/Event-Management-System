<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

try {
    // Dispatch the request
    App\Router::dispatch();
} catch (\Throwable $e) {
    // Handle all exceptions
    \App\Exceptions\Exception::handle($e);
}