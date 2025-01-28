<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Database\DatabaseManager;

$command = $argv[1] ?? null;

switch ($command) {
    case 'migrate':
        DatabaseManager::migrate();
        break;

    case 'seed':
        DatabaseManager::seed();
        break;

    case 'migrate:fresh':
        DatabaseManager::deleteAll();
        DatabaseManager::migrate();
        DatabaseManager::seed();
        break;

    default:
        echo "Invalid command. Use 'migrate', 'seed', or 'migrate:fresh'.\n";
}
