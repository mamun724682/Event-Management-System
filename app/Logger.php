<?php

namespace App;

class Logger
{
    public static function log($message, $type = 'error')
    {
        $logFile = __DIR__ . '/../storage/logs/app.log';
        $time = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$time] [$type] $message" . PHP_EOL, FILE_APPEND);
    }
}