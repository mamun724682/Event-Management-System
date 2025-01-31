<?php

namespace App\Controllers;

use App\Models\Event;
use App\Requests\Request;
use App\Response;
use App\View;

class EventController
{
    private $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    public function index()
    {
        $events = $this->model->orderBy('desc')->paginate();
        View::renderAndEcho('dashboard.events.index', [
            'events' => $events
        ]);
    }

    public function show($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            Response::error('Event not found', 404);
        }
        Response::success($item);
    }

    public function store()
    {
        $request = new Request();
        $data = $request->validate([
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:50',
        ]);
        $event = $this->model->create($data);
        Response::success($event, 'Event created successfully', 201);
    }

    public function update($id)
    {
        $request = new Request();
        $data = $request->validate([
            'name' => 'required|min:3|max:50',
            'description' => 'required|min:3|max:50',
        ]);
        
        $updated = $this->model->update($data, $id);
        if (!$updated) {
            Response::error('Event not found or update failed', 400);
        }
        Response::success($updated, 'Event updated successfully');
    }

    public function destroy($id)
    {
        $deleted = $this->model->delete($id);
        if (!$deleted) {
            Response::error('Event not found or deletion failed', 400);
        }
        Response::success(null, 'Event deleted successfully');
    }
}
