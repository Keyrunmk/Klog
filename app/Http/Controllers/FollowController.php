<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowController extends BaseController
{
    public function follow(User $user): array
    {
        return auth()->user()->following()->toggle($user);
    }
}
