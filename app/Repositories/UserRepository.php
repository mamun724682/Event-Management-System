<?php

namespace App\Repositories;

use App\Enums\SortOrderEnum;
use App\Enums\UserFieldsEnum;
use App\Enums\UserFiltersEnum;
use App\Models\User;
use Exception;

class UserRepository
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
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
        string $sortBy = UserFieldsEnum::ID->value,
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
     * @param array $payload
     * @return mixed
     * @throws Exception
     */
    public function create(array $payload): mixed
    {
        return $this->model->create(
            data: $payload,
        );
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
     * @return User
     */
    private function getQuery(array $filters = []): User
    {
        $model = $this->model;

        if (isset($filters[UserFiltersEnum::ID->value])) {
            $model->where(UserFieldsEnum::ID->value, $filters[UserFiltersEnum::ID->value]);
        }
        if (isset($filters[UserFiltersEnum::NAME->value])) {
            $model->where(UserFieldsEnum::NAME->value, 'like', "%{$filters[UserFiltersEnum::NAME->value]}%");
        }
        if (isset($filters[UserFiltersEnum::EMAIL->value])) {
            $model->where(UserFieldsEnum::EMAIL->value, $filters[UserFiltersEnum::EMAIL->value]);
        }

        return $model;
    }
}