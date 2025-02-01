<?php

namespace App\Controllers;

use App\Auth;
use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;
use App\Response;
use App\Services\UserService;
use App\View;

class AuthController
{
    private UserService  $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function showLogin()
    {
        View::renderAndEcho('auth.login');
    }

    public function login()
    {
        $request = new LoginRequest();
        $data = $request->validated();

        $user = $this->userService->findByEmail($data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {
            Auth::login($user);
            header('Location: /dashboard');
            exit();
        }

        Response::setFlashMessage('Invalid credentials. Please try again.', 'error');
        header('Location: /');
    }

    public function showRegister()
    {
        View::renderAndEcho('auth.register');
    }

    public function register()
    {
        $request = new RegisterRequest();
        $data = $request->validated();

        $user = $this->userService->findByEmail($data['email']);
        if ($user) {
            Response::setFlashMessage('You have already an account. Please login.', 'error');
            header('Location: /register');
            exit();
        }

        $this->userService->create($data);
        Response::setFlashMessage('Registration successful. Please login.');
        header('Location: /');
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /');
    }
}
