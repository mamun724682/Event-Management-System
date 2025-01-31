<?php

namespace App\Controllers;

use App\Auth;
use App\Models\User;
use App\Requests\Request;
use App\Response;
use App\View;

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function showLogin()
    {
        View::renderAndEcho('auth.login');
    }

    public function login()
    {
        $request = new Request();
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = $this->model->where('email', $data['email'])->first();

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
        $request = new Request();
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->model->create($data);

        Response::setFlashMessage('Registration successful. Please login.');
        header('Location: /');
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /');
    }
}
