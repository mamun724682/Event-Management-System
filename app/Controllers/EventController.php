<?php

namespace App\Controllers;

use App\Auth;
use App\Enums\AttendeeFiltersEnum;
use App\Enums\EventFieldsEnum;
use App\Requests\EventStoreRequest;
use App\Requests\EventUpdateRequest;
use App\Response;
use App\Services\AttendeeService;
use App\Services\EventService;
use App\View;

class EventController
{
    private EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    public function index()
    {
        View::renderAndEcho('dashboard.events.index');
    }

    public function create()
    {
        View::renderAndEcho('dashboard.events.create');
    }

    public function store()
    {
        $request = new EventStoreRequest();
        $data = $request->validated();
        $data[EventFieldsEnum::USER_ID->value] = Auth::id();
        $this->eventService->create($data);

        Response::setFlashMessage('Event created successfully.');
        header('Location: /events');
    }

    public function edit($id)
    {
        $event = $this->eventService->findByIdAndUser(
            id: $id,
            userId: Auth::id()
        );
        if (!$event) {
            View::renderAndEcho('errors.error', [
                'code'    => 404,
                'message' => "Event not found for id: " . $id,
                'trace'   => null
            ]);
            exit();
        }

        View::renderAndEcho('dashboard.events.edit', [
            'event' => $event,
        ]);
    }

    public function update($id)
    {
        $request = new EventUpdateRequest();
        $data = $request->validated();

        $event = $this->eventService->findByIdAndUser(
            id: $id,
            userId: Auth::id()
        );
        if (!$event) {
            View::renderAndEcho('errors.error', [
                'code'    => 404,
                'message' => "Event not found for id: " . $id,
                'trace'   => null
            ]);
            exit();
        }

        $updated = $this->eventService->update(
            event: $event,
            payload: $data
        );
        if (!$updated) {
            Response::setFlashMessage('Event not found or update failed.', 'error');
        }

        Response::setFlashMessage('Event updated successfully.');
        header('Location: /events');
    }

    public function destroy($id)
    {
        $event = $this->eventService->findByIdAndUser(
            id: $id,
            userId: Auth::id()
        );
        if (!$event) {
            View::renderAndEcho('errors.error', [
                'code'    => 404,
                'message' => "Event not found for id: " . $id,
                'trace'   => null
            ]);
            exit();
        }

        $this->eventService->delete($event);

        Response::setFlashMessage('Event deleted successfully.');
        header('Location: /events');
    }

    public function showRegister(string $slug)
    {
        $event = $this->eventService->findBySlug(
            slug: $slug,
        );
        if (!$event) {
            View::renderAndEcho('errors.error', [
                'code'    => 404,
                'message' => "Corresponding event not found!",
                'trace'   => null
            ]);
            exit();
        }

        View::renderAndEcho('guest.event', [
            'event' => $event,
        ]);
    }

    public function export($id)
    {
        $event = $this->eventService->findByIdAndUser(
            id: $id,
            userId: Auth::id()
        );
        if (!$event) {
            View::renderAndEcho('errors.error', [
                'code'    => 404,
                'message' => "Event not found for id: " . $id,
                'trace'   => null
            ]);
            exit();
        }

        $attendeeService = new AttendeeService();
        $attendees = $attendeeService->getAll([
            "perPage" => 5000,
            AttendeeFiltersEnum::EVENT_ID->value => $event['id'],
            AttendeeFiltersEnum::USER_ID->value  => Auth::id(),
        ]);

        $this->eventService->export(
            event: $event,
            attendees: $attendees
        );
    }
}
