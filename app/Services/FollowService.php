<?php

namespace App\Services;

use App\Models\User;
use Exception;

class FollowService
{
    public function followProfile(User $user): string
    {
        try {
            $response = auth()->user()->following()->toggle($user);
        } catch (Exception $e) {
            throw $e;
        }

        if (!empty($response["attached"])) {
            return "Following profile id " . $response["attached"][0];
        }

        return "Unfollowed profile id " . $response["detached"][0];
    }
}
