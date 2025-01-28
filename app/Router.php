<?php

namespace App;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, array|callable $callback): void
    {
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post(string $uri, array $callback): void
    {
        self::$routes['POST'][$uri] = $callback;
    }

    public static function put($uri, $callback): void
    {
        self::$routes['PUT'][$uri] = $callback;
    }

    public static function delete($uri, $callback): void
    {
        self::$routes['DELETE'][$uri] = $callback;
    }

    public static function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        require_once __DIR__ . '/../routes/api.php'; // Include routes here.

        foreach (self::$routes[$method] ?? [] as $route => $callback) {
            // Convert route pattern to a regex (e.g., /events/{id} -> /events/([^/]+))
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove the full match
                self::invoke($callback, $matches); // Pass matched parameters
                return;
            }
        }

        self::send404();
    }

    private static function invoke($callback, $params = [])
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        } elseif (is_array($callback)) {
            [$controller, $method] = $callback;
            $instance = new $controller;
            if (method_exists($instance, $method)) {
                call_user_func_array([$instance, $method], $params);
            } else {
                self::send404();
            }
        } else {
            self::send404();
        }
    }

    private static function send404(): void
    {
        http_response_code(404);
        echo "Route Not Found";
    }
}
