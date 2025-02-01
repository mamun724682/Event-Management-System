<?php

namespace App\Controllers\Api;

use App\Auth;
use App\Enums\EventFiltersEnum;
use App\Requests\EventIndexRequest;
use App\Response;
use App\Services\EventService;

class EventController
{
    private EventService $service;

    public function __construct()
    {
        $this->service = new EventService();
    }

    public function index()
    {
        $request = new EventIndexRequest();
        $queryParameters = $request->validated();
        $queryParameters[EventFiltersEnum::USER_ID->value] = Auth::id();

        Response::success(
            data: $this->service->getAll($queryParameters),
            message: 'Events retrieved successfully.'
        );
    }
}