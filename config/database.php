<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'mysql' => [
        'host'     => $_ENV['DB_HOST'] ?? "localhost",
        'database' => $_ENV['DB_DATABASE'] ?? "test",
        'username' => $_ENV['DB_USERNAME'] ?? "root",
        'password' => $_ENV['DB_PASSWORD'] ?? "",
    ],
];