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
     * @param array $event
     * @param array $payload
     * @return mixed
     * @throws Exception
     */
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
}