<?php

namespace App\Requests;

class AttendeeIndexRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->validate($this->rules());
    }

    public function rules(): array
    {
        return [
            'event_id'  => 'nullable',
            'name'      => 'nullable|string',
            'email'     => 'nullable|string',
            'sortBy'    => 'nullable|string',
            'sortOrder' => 'nullable|string',
            'page'      => 'nullable|numeric|min:1',
            'perPage'   => 'nullable|numeric|min:1',
        ];
    }
}