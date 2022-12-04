<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;
use Exception;

class UserRepository extends BaseRepository implements UserContract
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
