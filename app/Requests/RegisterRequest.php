<?php

namespace App\Requests;

class RegisterRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->validate($this->rules());
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|min:3',
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ];
    }
}