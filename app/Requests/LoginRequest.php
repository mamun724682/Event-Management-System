<?php

namespace App\Requests;

class LoginRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->validate($this->rules());
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ];
    }
}