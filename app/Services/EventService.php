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

        print_r(EventFiltersEnum::cases());
        die();
        return $this->eventRepository->getAll(
            page: $page,
            perPage: $perPage,
            filters: Helper::getFiltersValues($queryParameters, EventFiltersEnum::cases()),
            sortBy: $queryParameters["sortBy"] ?? EventFieldsEnum::ID->value,
            sortOrder: $queryParameters["sortOrder"] ?? SortOrderEnum::DESC->value
        );
    }
}