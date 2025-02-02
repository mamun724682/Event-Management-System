<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Database\DatabaseManager;

$command = $argv[1] ?? null;

if ($command == 'migrate') {
    DatabaseManager::migrate();
} elseif ($command == 'rollback') {
    DatabaseManager::deleteAll();
} elseif ($command == 'seed') {
    DatabaseManager::seed();
} elseif ($command == 'migrate:fresh') {
    DatabaseManager::deleteAll();
    DatabaseManager::migrate();
    DatabaseManager::seed();
} else {
    echo "Invalid command. Use 'migrate', 'seed', or 'migrate:fresh'.\n";
}

echo 'Database command done.' . PHP_EOL;
return true;