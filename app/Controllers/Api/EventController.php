<?php

namespace App\Controllers\Api;

use App\Auth;
use App\Enums\EventFiltersEnum;
use App\Exceptions\AttendeeCreateException;
use App\Requests\EventIndexRequest;
use App\Requests\Request;
use App\Response;
use App\Services\AttendeeService;
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

    public function register(string $slug)
    {
        $request = new Request();
        $data = $request->validate([
            'name'  => 'required|min:3|max:50',
            'email' => 'required|min:3|max:50',
            'phone' => 'required|min:3|max:50',
        ]);
        $event = $this->service->findBySlug($slug);
        $attendeeService = new AttendeeService();

        try {
            Response::success(
                data: $attendeeService->create(
                    event: $event,
                    payload: $data
                ),
                message: 'Event registration successful.'
            );
        } catch (AttendeeCreateException $e) {
            Response::error(
                message: $e->getMessage(),
                status: 400
            );
        } catch (\Exception $e) {
            Response::error(
                message: 'Registration failed. Something went wrong.',
                status: 500
            );
        }
    }
}