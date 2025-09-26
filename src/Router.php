<?php

namespace BookMyHouse;

class Router
{
    private array $routes = [];

    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$path] = [$controller, $action];
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$path] = [$controller, $action];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash except for root
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }

        if (isset($this->routes[$method][$path])) {
            [$controllerClass, $action] = $this->routes[$method][$path];
            
            $controller = new $controllerClass();
            $controller->$action();
        } else {
            http_response_code(404);
            echo "404 - Page Not Found";
        }
    }

    public function setupRoutes(): void
    {
        // Root route
        $this->get('/', 'BookMyHouse\\Controllers\\BookingsController', 'index');
        
        // Bookings routes
        $this->get('/bookings', 'BookMyHouse\\Controllers\\BookingsController', 'index');
        $this->get('/bookings/new', 'BookMyHouse\\Controllers\\BookingsController', 'new');
        $this->post('/bookings', 'BookMyHouse\\Controllers\\BookingsController', 'create');
        
        // Query routes
        $this->get('/query/new', 'BookMyHouse\\Controllers\\QueriesController', 'new');
        $this->post('/query', 'BookMyHouse\\Controllers\\QueriesController', 'create');
        
        // Statistics route
        $this->get('/statistics', 'BookMyHouse\\Controllers\\StatisticsController', 'show');
        
        // API routes
        $this->post('/api/query', 'BookMyHouse\\Controllers\\Api\\QueriesController', 'create');
    }
}