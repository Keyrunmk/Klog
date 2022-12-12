<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Enum\UserStatusEnum;
use App\facades\UserLocation;
use App\Models\User;
use Exception;

class UserRepository extends BaseRepository implements UserContract
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function setLocation(User $user): void
    {
        try {
            $userLocation = UserLocation::getCountryName();
            $user->location()->create(["country_name" => $userLocation]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findWhere(string $email, UserStatusEnum $status): mixed
    {
        try {
            return $this->model->where("email", $email)->where("status", $status)->first();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
