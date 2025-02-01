<?php

namespace App\Controllers\Api;

use App\Auth;
use App\Enums\AttendeeFiltersEnum;
use App\Requests\AttendeeIndexRequest;
use App\Response;
use App\Services\AttendeeService;

class AttendeeController
{
    private AttendeeService $service;

    public function __construct()
    {
        $this->service = new AttendeeService();
    }

    public function index()
    {
        $request = new AttendeeIndexRequest();
        $queryParameters = $request->validated();
        $queryParameters[AttendeeFiltersEnum::USER_ID->value] = Auth::id();

        Response::success(
            data: $this->service->getAll($queryParameters),
            message: 'Attendees retrieved successfully.'
        );
    }
}