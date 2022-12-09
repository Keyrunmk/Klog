<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FollowService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowController extends BaseController
{
    public FollowService $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function follow(User $user): JsonResponse
    {
        try {
            $response = $this->followService->followProfile($user);
        } catch (Exception $e) {
            return $this->errorResponse("Something went wrong", (int)$e->getCode());
        }

        return $this->successResponse($response);
    }
}
