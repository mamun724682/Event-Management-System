<?php

namespace App\Controllers\Api;

use App\Auth;
use App\Models\Event;
use App\Requests\Request;
use App\Response;

class EventController
{
    private Event $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    public function index()
    {
        $request = new Request();
        $data = $request->all();

        $events = $this->model->where('user_id', Auth::id())->orderBy('desc')->paginate(
            perPage: $data['perPage'] ?? 10,
            currentPage: $data['page'] ?? 1
        );
        Response::success(
            data: $events,
            message: 'Events retrieved successfully.'
        );
    }
}