<?php

namespace App\Services;

use App\Enums\AttendeeFieldsEnum;
use App\Enums\AttendeeFiltersEnum;
use App\Enums\EventFieldsEnum;
use App\Enums\SortOrderEnum;
use App\Exceptions\AttendeeCreateException;
use App\Helper\Helper;
use App\Repositories\AttendeeRepository;
use Exception;

class AttendeeService
{
    private AttendeeRepository $attendeeRepository;

    public function __construct()
    {
        $this->attendeeRepository = new AttendeeRepository();
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

        return $this->attendeeRepository->getAll(
            page: $page,
            perPage: $perPage,
            filters: Helper::getFiltersValues($queryParameters, AttendeeFiltersEnum::values()),
            sortBy: $queryParameters["sortBy"] ?? AttendeeFieldsEnum::ID->value,
            sortOrder: $queryParameters["sortOrder"] ?? SortOrderEnum::DESC->value
        );
    }

    public function create(array $event, array $payload)
    {
        $attendees = $this->getAll([
            AttendeeFiltersEnum::EVENT_ID->value => $event[EventFieldsEnum::ID->value],
        ]);

        // Check event capacity
        if ($attendees['total'] >= $event[EventFieldsEnum::CAPACITY->value]) {
            throw new AttendeeCreateException("Event capacity limit exceeded!");
        }

        // Check already registered
        $attendees = $this->getAll([
            AttendeeFiltersEnum::EVENT_ID->value => $event[EventFieldsEnum::ID->value],
            AttendeeFiltersEnum::EMAIL->value => $payload[AttendeeFieldsEnum::EMAIL->value],
            AttendeeFiltersEnum::PHONE->value => $payload[AttendeeFieldsEnum::PHONE->value],
        ]);
        if ($attendees['total'] > 0) {
            throw new AttendeeCreateException("You have already registered to this event!");
        }

        $processPayload = [
            AttendeeFieldsEnum::EVENT_ID->value   => $event['id'],
            AttendeeFieldsEnum::NAME->value       => $payload[AttendeeFieldsEnum::NAME->value],
            AttendeeFieldsEnum::EMAIL->value      => $payload[AttendeeFieldsEnum::EMAIL->value],
            AttendeeFieldsEnum::PHONE->value      => $payload[AttendeeFieldsEnum::PHONE->value],
            AttendeeFieldsEnum::CREATED_AT->value => (new \DateTime())->format("Y-m-d H:i:s"),
            AttendeeFieldsEnum::UPDATED_AT->value => (new \DateTime())->format("Y-m-d H:i:s"),
        ];

        $attendee = $this->attendeeRepository->create(payload: $processPayload);

        // Increase event attendee counter
        $eventService = new EventService();
        $event = $eventService->update(
            event: $event,
            payload: [
                EventFieldsEnum::TOTAL_ATTENDEES->value => $event[EventFieldsEnum::TOTAL_ATTENDEES->value] + 1,
            ]
        );

        return $event;
    }
}