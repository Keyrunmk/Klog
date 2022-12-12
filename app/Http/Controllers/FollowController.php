<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\FollowService;
use Exception;
use Illuminate\Http\JsonResponse;
class FollowController extends BaseController
{
    public FollowService $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function follow(int $profile_id): JsonResponse
    {
        try {
            $response = $this->followService->followProfile($profile_id);
        } catch(NotFoundException $e) {
            return $this->errorResponse("Couldn't find the profile to follow", (int) $e->getCode());
        }catch (Exception $e) {
            return $this->errorResponse("Something went wrong", (int)$e->getCode());
        }

        return $this->successResponse($response);
    }
}
