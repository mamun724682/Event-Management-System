<?php

namespace App;

class Response
{
    public static function success($data, $message = 'Success', $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode([
            'message' => $message,
            'data'    => $data,
        ]);
        exit;
    }

    public static function error($message, $status = 400)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode([
            'message' => $message,
        ]);
        exit;
    }

    public static function validationError(array $errors, $status = 422)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode([
            'message' => array_values($errors)[0][0],
            'errors'  => $errors,
        ]);
        exit;
    }
}
