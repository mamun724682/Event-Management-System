<?php

namespace App\Requests;

class EventIndexRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->validate($this->rules());
    }

    public function rules(): array
    {
        return [
            'page'    => 'nullable|numeric|min:1',
            'perPage' => 'nullable|numeric|min:1',
            'search'  => 'nullable|string',
        ];
    }
}