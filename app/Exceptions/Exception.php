<?php

namespace App\Exceptions;

use App\Logger;
use App\Response;
use App\View;

class Exception
{
    public static function handle(\Throwable $exception)
    {
        Logger::log($exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine());

        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            // Return JSON response for API
            Response::error('An unexpected error occurred.', 500);
        } else {
            View::renderAndEcho('errors.error', [
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
                'trace'   => $exception->getTraceAsString()
            ]);
        }

        exit;
    }
}