<?php

namespace App\Requests;

use App\Response;

class Request
{
    protected array $data;
    protected array $validatedData = [];

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST, json_decode(file_get_contents('php://input'), true) ?? []);
    }

    /**
     * Get a specific key from the request data or default.
     */
    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Get all request data.
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Get validated data.
     */
    public function validated(): array
    {
        return $this->validatedData;
    }

    /**
     * Validate the request data against rules.
     */
    public function validate(array $rules): array
    {
        $errors = [];
        $this->validatedData = [];

        foreach ($rules as $field => $rule) {
            $value = $this->input($field);

            foreach (explode('|', $rule) as $r) {
                if ($r === 'required' && !$value) {
                    $errors[$field][] = "$field field is required";
                } elseif ($r === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = "$field field must be a number";
                } elseif ($r === 'integer' && !is_integer($value)) {
                    $errors[$field][] = "$field field must be an integer";
                } elseif (str_starts_with($r, 'min:')) {
                    $min = (int) explode(':', $r)[1];
                    if ($value && strlen($value) < $min) {
                        $errors[$field][] = "$field field must be at least $min characters";
                    }
                } elseif (str_starts_with($r, 'max:')) {
                    $max = (int) explode(':', $r)[1];
                    if ($value && strlen($value) > $max) {
                        $errors[$field][] = "$field field must not exceed $max characters";
                    }
                } elseif ($r === 'email') {
                    if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = "$field field must must be an email";
                    }
                }
            }

            // If no errors, add field to validated data
            if (!isset($errors[$field])) {
                $this->validatedData[$field] = $value;
            }
        }

        if (!empty($errors)) {
            $this->handleValidationErrors($errors);
        }

        return $this->validatedData;
    }

    /**
     * @param array $errors
     * @return void
     */
    protected function handleValidationErrors(array $errors)
    {
        if (str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            Response::validationError($errors);
        } else {
            // Redirect back for web errors with session storage
            $_SESSION['errors'] = $errors;

            $referer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
            header('Location: ' . $referer);
        }
        exit;
    }

    /**
     * @return array
     */
    public static function errors(): array
    {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        $errorData = [];
        foreach ($errors as $field => $error) {
            $errorData[$field] = join(', ', $error);
        }

        return $errorData;
    }

    public static function url()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}