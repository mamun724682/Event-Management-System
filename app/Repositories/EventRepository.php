<?php

namespace App\Repositories;

use App\Enums\EventFieldsEnum;
use App\Enums\EventFiltersEnum;
use App\Enums\SortOrderEnum;
use App\Models\Event;
use Exception;

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
     * @throws Exception
     */
    public function getAll(
        int    $page,
        int    $perPage,
        array  $filters = [],
        string $sortBy = EventFieldsEnum::ID->value,
        string $sortOrder = SortOrderEnum::ASC->value
    ): array
    {
        return $this->getQuery($filters)->orderBy(
            direction: $sortOrder,
            column: $sortBy
        )->paginate(
            perPage: $perPage,
            currentPage: $page
        );
    }

    /**
     * @param array $filters
     * @return mixed
     * @throws Exception
     */
    public function find(array $filters = []): mixed
    {
        return $this->getQuery($filters)->first();
    }

    /**
     * @param int $id
     * @param array $changes
     * @return mixed
     * @throws Exception
     */
    public function update(int $id, array $changes): mixed
    {
        return $this->model->update(
            data: $changes,
            id: $id
        );
    }

    /**
     * @param array $filters
     * @return Event
     */
    private function getQuery(array $filters = []): Event
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

        return $model;
    }
}