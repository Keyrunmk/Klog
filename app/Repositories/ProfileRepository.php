<?php

namespace App\Repositories;

use App\Contracts\ProfileContract;
use App\Models\Profile;

class ProfileRepository extends BaseRepository implements ProfileContract
{
    public function __construct(Profile $model)
    {
        parent::__construct($model);
    }
}