<?php

namespace App\Repositories;

use App\Enums\AttendeeFieldsEnum;
use App\Enums\AttendeeFiltersEnum;
use App\Enums\SortOrderEnum;
use App\Models\Attendee;
use Exception;

class AttendeeRepository
{
    private Attendee $model;

    public function __construct()
    {
        $this->model = new Attendee();
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
        string $sortBy = AttendeeFieldsEnum::ID->value,
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
     * @throws Exception
     */
    public function create(array $payload)
    {
        return $this->model->create($payload);
    }

    /**
     * @param array $filters
     * @return Attendee
     */
    private function getQuery(array $filters = []): Attendee
    {
        $model = $this->model;

        if (isset($filters[AttendeeFiltersEnum::ID->value])) {
            $model->where(AttendeeFieldsEnum::ID->value, $filters[AttendeeFiltersEnum::ID->value]);
        }
        if (isset($filters[AttendeeFiltersEnum::USER_ID->value])) {
            $model->where(AttendeeFieldsEnum::USER_ID->value, $filters[AttendeeFiltersEnum::USER_ID->value]);
        }
        if (isset($filters[AttendeeFiltersEnum::EVENT_ID->value])) {
            $model->where(AttendeeFieldsEnum::EVENT_ID->value, $filters[AttendeeFiltersEnum::EVENT_ID->value]);
        }
        if (isset($filters[AttendeeFiltersEnum::NAME->value])) {
            $model->where(AttendeeFieldsEnum::NAME->value, 'like', "%{$filters[AttendeeFiltersEnum::NAME->value]}%");
        }
        if (isset($filters[AttendeeFiltersEnum::PHONE->value])) {
            $model->where(AttendeeFieldsEnum::PHONE->value, 'like', "%{$filters[AttendeeFiltersEnum::PHONE->value]}%");
        }
        if (isset($filters[AttendeeFiltersEnum::EMAIL->value])) {
            $model->where(AttendeeFieldsEnum::EMAIL->value, $filters[AttendeeFiltersEnum::EMAIL->value]);
        }

        return $model;
    }
}