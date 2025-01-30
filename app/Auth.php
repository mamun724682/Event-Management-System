<?php

namespace App;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['authUser']);
    }

    public static function user()
    {
        return $_SESSION['authUser'] ?? null;
    }

    public static function login($user)
    {
        $_SESSION['authUser'] = $user;
    }

    public static function logout()
    {
        unset($_SESSION['authUser']);
        session_destroy();
    }

    public static function requireAuth()
    {
        if (!self::check()) {
            header('Location: /');
            exit;
        }
    }

    // Middleware to prevent logged-in users from accessing login/register
    public static function guestOnly()
    {
        if (self::check()) {
            header('Location: /dashboard');
            exit;
        }
    }
}