<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Event;
use App\Models\User;
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
        $events = $this->model->where('user_id', Auth::id())->orderBy('desc')->paginate();
        View::renderAndEcho('dashboard.events.index', [
            'events' => $events
        ]);
    }

    public function create()
    {
        $users = (new User)->orderBy('desc')->get();
        View::renderAndEcho('dashboard.events.create', [
            'users' => $users
        ]);
    }

    public function store()
    {
        $request = new Request();
        $data = $request->validate([
            'name'        => 'required|min:3|max:50',
            'location'    => 'required|min:3|max:50',
            'capacity'    => 'required|min:1|numeric',
            'description' => 'required',
            'date'        => 'required|date',
        ]);
        $data["user_id"] = Auth::id();
        $data["slug"] = $this->generateSlug($data["name"]);
        $data["created_at"] = (new \DateTime())->format("Y-m-d H:i:s");
        $data["updated_at"] = (new \DateTime())->format("Y-m-d H:i:s");
        $event = $this->model->create($data);

        Response::setFlashMessage('Event created successfully.');
        header('Location: /events');
    }

    private function generateSlug($name): string
    {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        return trim($slug, '-');
    }

    public function update($id)
    {
        $request = new Request();
        $data = $request->validate([
            'name'        => 'required|min:3|max:50',
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
