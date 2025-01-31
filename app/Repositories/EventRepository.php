<?php

namespace App\Repositories;

use App\Enums\EventFieldsEnum;
use App\Enums\EventFiltersEnum;
use App\Enums\SortOrderEnum;
use App\Models\Event;

class EventRepository
{
    private Event $model;

    public function __construct()
    {
        $this->model = new Event();
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @param string $sortBy
     * @param string $sortOrder
     * @return array|int[]
     * @throws \Exception
     */
    public function getAll(
        int    $page,
        int    $perPage,
        array  $filters = [],
        string $sortBy = EventFieldsEnum::ID->value,
        string $sortOrder = SortOrderEnum::ASC->value
    ): array
    {
        $model = $this->model;

        if (isset($filters[EventFiltersEnum::ID->value])) {
            $model->where(EventFieldsEnum::ID->value, $filters[EventFiltersEnum::ID->value]);
        }
        if (isset($filters[EventFiltersEnum::USER_ID->value])) {
            $model->where(EventFieldsEnum::USER_ID->value, $filters[EventFiltersEnum::USER_ID->value]);
        }
        if (isset($filters[EventFiltersEnum::NAME->value])) {
            $model->where(EventFieldsEnum::NAME->value, 'like', "%{$filters[EventFiltersEnum::NAME->value]}%");
        }
        if (isset($filters[EventFiltersEnum::SLUG->value])) {
            $model->where(EventFieldsEnum::SLUG->value, $filters[EventFiltersEnum::SLUG->value]);
        }
        if (isset($filters[EventFiltersEnum::DATE->value])) {
            $model->where(EventFieldsEnum::DATE->value, $filters[EventFiltersEnum::DATE->value]);
        }
        if (isset($filters[EventFiltersEnum::LOCATION->value])) {
            $model->where(EventFieldsEnum::LOCATION->value, 'like', "%{$filters[EventFiltersEnum::LOCATION->value]}%");
        }
        if (isset($filters[EventFiltersEnum::CAPACITY->value])) {
            $model->where(EventFieldsEnum::CAPACITY->value, $filters[EventFiltersEnum::CAPACITY->value]);
        }
        if (isset($filters[EventFiltersEnum::DESCRIPTION->value])) {
            $model->where(EventFieldsEnum::DESCRIPTION->value, 'like', "%{$filters[EventFiltersEnum::DESCRIPTION->value]}%");
        }

        return $model->orderBy(
            direction: $sortOrder,
            column: $sortBy
        )->paginate(
            perPage: $perPage,
            currentPage: $page
        );
    }
}