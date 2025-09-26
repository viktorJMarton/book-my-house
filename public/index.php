<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BookMyHouse\Database;
use BookMyHouse\Router;

// Initialize database
try {
    Database::createTables();
} catch (\Exception $e) {
    die('Database initialization failed: ' . $e->getMessage());
}

// Set up routing
$router = new Router();
$router->setupRoutes();

// Handle the request
$router->dispatch();