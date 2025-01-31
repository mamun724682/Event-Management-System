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

    /**
     * @throws \Exception
     */
    public static function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Include routes here.
        require_once __DIR__ . '/../routes/web.php';
        require_once __DIR__ . '/../routes/api.php';

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

        self::sendError('Whoops! Route not found.');
    }

    /**
     * @throws \Exception
     */
    private static function invoke($callback, $params = [])
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        } elseif (is_array($callback)) {
            $controller = $callback[0];
            $method = $callback[1];

            self::checkMiddleware($callback[2] ?? null);

            $instance = new $controller;
            if (method_exists($instance, $method)) {
                call_user_func_array([$instance, $method], $params);
            } else {
                self::sendError("{$controller} called undefined method '{$method}'.");
            }
        } else {
            self::sendError();
        }
    }

    private static function checkMiddleware(string $middleware = null)
    {
        if ($middleware) {
            if ($middleware == 'auth') {
                Auth::requireAuth();
            } elseif ($middleware == 'guest') {
                Auth::guestOnly();
            }
        }
    }

    private static function sendError($message = 'Whoops! Something went wrong.'): void
    {
        throw new \Exception($message, 404);
    }
}
