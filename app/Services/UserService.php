<?php

namespace App\Services;

use App\Enums\SortOrderEnum;
use App\Enums\UserFieldsEnum;
use App\Enums\UserFiltersEnum;
use App\Helper\Helper;
use App\Repositories\UserRepository;
use Exception;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
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

        return $this->userRepository->getAll(
            page: $page,
            perPage: $perPage,
            filters: Helper::getFiltersValues($queryParameters, UserFiltersEnum::values()),
            sortBy: $queryParameters["sortBy"] ?? UserFieldsEnum::ID->value,
            sortOrder: $queryParameters["sortOrder"] ?? SortOrderEnum::DESC->value
        );
    }

    /**
     * @param string $email
     * @return mixed
     * @throws Exception
     */
    public function findByEmail(string $email): mixed
    {
        return $this->userRepository->find([
            UserFiltersEnum::EMAIL->value => $email,
        ]);
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws Exception
     */
    public function create(array $payload): mixed
    {
        $processPayload = [
            UserFieldsEnum::NAME->value       => $payload[UserFieldsEnum::NAME->value],
            UserFieldsEnum::EMAIL->value      => $payload[UserFieldsEnum::EMAIL->value],
            UserFieldsEnum::PASSWORD->value   => password_hash($payload[UserFieldsEnum::PASSWORD->value], PASSWORD_BCRYPT),
            UserFieldsEnum::CREATED_AT->value => (new \DateTime())->format("Y-m-d H:i:s"),
            UserFieldsEnum::UPDATED_AT->value => (new \DateTime())->format("Y-m-d H:i:s"),
        ];

        return $this->userRepository->create(
            payload: $processPayload
        );
    }
}