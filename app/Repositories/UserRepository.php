<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;

class UserRepository extends BaseRepository implements UserContract
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function createUser(array $attibutes): mixed
    {
        return $this->create($attibutes);
    }
}
