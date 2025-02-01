<?php

namespace App\Services;

use App\Enums\EventFieldsEnum;
use App\Enums\EventFiltersEnum;
use App\Enums\SortOrderEnum;
use App\Helper\Helper;
use App\Repositories\EventRepository;
use Exception;

class EventService
{
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }

    /**
     * @param array $queryParameters
     * @return array|int[]
     * @throws Exception
     */
    public function getAll(array $queryParameters): array
    {
        $page = $queryParameters['page'] ?? 1;
        $perPage = $queryParameters['perPage'] ?? 10;

        return $this->eventRepository->getAll(
            page: $page,
            perPage: $perPage,
            filters: Helper::getFiltersValues($queryParameters, EventFiltersEnum::values()),
            sortBy: $queryParameters["sortBy"] ?? EventFieldsEnum::ID->value,
            sortOrder: $queryParameters["sortOrder"] ?? SortOrderEnum::DESC->value
        );
    }

    public function findBySlug(string $slug)
    {
        return $this->eventRepository->find(
            filters: [
                EventFiltersEnum::SLUG->value => $slug,
            ]
        );
    }

    /**
     * @param int $id
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public function findByIdAndUser(int $id, int $userId): mixed
    {
        return $this->eventRepository->find(
            filters: [
                EventFiltersEnum::ID->value      => $id,
                EventFiltersEnum::USER_ID->value => $userId,
            ]
        );
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws Exception
     */
    public function create(array $payload): mixed
    {
        $processPayload = [
            EventFieldsEnum::USER_ID->value         => $payload[EventFieldsEnum::USER_ID->value],
            EventFieldsEnum::NAME->value            => $payload[EventFieldsEnum::NAME->value],
            EventFieldsEnum::SLUG->value            => $this->generateSlug($payload[EventFieldsEnum::NAME->value]),
            EventFieldsEnum::DATE->value            => $payload[EventFieldsEnum::DATE->value],
            EventFieldsEnum::LOCATION->value        => $payload[EventFieldsEnum::LOCATION->value],
            EventFieldsEnum::CAPACITY->value        => $payload[EventFieldsEnum::CAPACITY->value],
            EventFieldsEnum::TOTAL_ATTENDEES->value => 0,
            EventFieldsEnum::DESCRIPTION->value     => $payload[EventFieldsEnum::DESCRIPTION->value],
            EventFieldsEnum::CREATED_AT->value      => (new \DateTime())->format("Y-m-d H:i:s"),
            EventFieldsEnum::UPDATED_AT->value      => (new \DateTime())->format("Y-m-d H:i:s"),
        ];

        return $this->eventRepository->create(
            payload: $processPayload
        );
    }

    private function generateSlug($name): string
    {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        return trim($slug, '-');
    }

    public function update(array $event, array $payload): mixed
    {
        $processPayload = [
            EventFieldsEnum::NAME->value            => $payload[EventFieldsEnum::NAME->value] ?? $event[EventFieldsEnum::NAME->value],
            EventFieldsEnum::DATE->value            => $payload[EventFieldsEnum::DATE->value] ?? $event[EventFieldsEnum::DATE->value],
            EventFieldsEnum::LOCATION->value        => $payload[EventFieldsEnum::LOCATION->value] ?? $event[EventFieldsEnum::LOCATION->value],
            EventFieldsEnum::CAPACITY->value        => $payload[EventFieldsEnum::CAPACITY->value] ?? $event[EventFieldsEnum::CAPACITY->value],
            EventFieldsEnum::TOTAL_ATTENDEES->value => $payload[EventFieldsEnum::TOTAL_ATTENDEES->value] ?? $event[EventFieldsEnum::TOTAL_ATTENDEES->value],
            EventFieldsEnum::DESCRIPTION->value     => $payload[EventFieldsEnum::DESCRIPTION->value] ?? $event[EventFieldsEnum::DESCRIPTION->value],
            EventFieldsEnum::UPDATED_AT->value      => (new \DateTime())->format("Y-m-d H:i:s"),
        ];

        return $this->eventRepository->update(
            id: $event['id'],
            changes: $processPayload
        );
    }

    /**
     * @param array $event
     * @return void
     * @throws Exception
     */
    public function delete(array $event)
    {
        $this->eventRepository->delete(id: $event['id']);
    }

    /**
     * @param array $event
     * @param array $attendees
     * @return void
     */
    public function export(array $event, array $attendees)
    {
        $csvHeader = ["Event Name", "Attendee Name", "Email", "Phone", "Registered At"];
        $csvData = [];
        foreach ($attendees['data'] as $attendee) {
            $csvData[] = [
                $event['name'],
                $attendee['name'],
                $attendee['email'],
                '="' . $attendee['phone'] . '"',
                $attendee['created_at'],
            ];
        }

        $filename = "event_attendees_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $file = fopen('php://output', 'w');
        fputcsv($file, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
        exit;
    }
}