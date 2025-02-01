<?php

namespace App\Requests;

class EventUpdateRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->validate($this->rules());
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|min:3|max:50',
            'location'    => 'required|min:3|max:50',
            'capacity'    => 'required|min:1|numeric',
            'description' => 'required',
            'date'        => 'required|date',
        ];
    }
}