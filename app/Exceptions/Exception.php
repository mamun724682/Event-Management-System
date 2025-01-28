<?php

namespace App\Exceptions;

use App\Logger;
use App\Response;

class Exception
{
    public static function handle(\Throwable $exception)
    {
        Logger::log($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());

        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            // Return JSON response for API
            Response::error('An unexpected error occurred.', 500);
        } else {
            // Return HTML response for web requests
            http_response_code(500);
            echo '<h1>500 Internal Server Error</h1>';
            echo '<p>An unexpected error occurred. Please try again later.</p>';
            echo '<pre>' . $exception->getMessage() . '</pre>';
            echo '<pre>' . $exception->getTraceAsString() . '</pre>';
        }

        exit;
    }
}