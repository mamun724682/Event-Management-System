<?php

namespace App\Controllers;

use App\Models\Event;
use App\Requests\Request;
use App\Response;
use App\View;

class AuthController
{
    private $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    public function showLogin()
    {
        View::renderAndEcho('auth.login');
    }

    public function login()
    {
        $request = new Request();
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6'
        ]);
        print_r($data);
        die();
        $data = $request->validate([
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:50',
        ]);

        $user = (new User())->findByEmail($data['email']);

        if ($user && password_verify($data['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /dashboard');
            exit();
        }

        return view('auth/login', ['error' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        $data = $request->validated([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        (new User())->create($data);

        return redirect('/login');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        return redirect('/login');
    }
}
