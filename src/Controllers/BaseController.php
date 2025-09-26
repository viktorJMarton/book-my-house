<?php

namespace BookMyHouse\Controllers;

class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        
        ob_start();
        include __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();
        
        include __DIR__ . "/../Views/layouts/application.php";
    }

    protected function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    protected function jsonResponse(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function getParam(string $key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function getParams(): array
    {
        return array_merge($_GET, $_POST);
    }
}