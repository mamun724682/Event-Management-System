<?php

namespace App;

class View
{
    public static function render($view, $data = []) {
        $viewPath = __DIR__ . '/../views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View [$view] not found.", 404);
        }

        // Extract data variables to be used in the view
        $data['validationErrors'] = \App\Requests\Request::errors();
        $data['flashMessage'] = \App\Response::getFlashMessage();
        extract($data);

        // Buffer the output to include the view file
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }

    public static function renderAndEcho($view, $data = []) {
        echo self::render($view, $data);
    }
}