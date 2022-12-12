<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Events\VerifyUserEvent;
use App\Models\User;
use App\Services\UserService;
use App\Services\UserVerify;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    protected UserService $userService;
    protected UserVerify $userVerify;

    public function __construct(UserService $userService, UserVerify $userVerify)
    {
        $this->userService = $userService;
        $this->userVerify = $userVerify;
    }

    public function register(Request $request): mixed
    {
        try {
            $user = $this->userService->register($request);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), (int) $exception->getCode());
        }

        return UserRegisteredEvent::dispatch($user);
    }

    public function verify(User $user, Request $request): JsonResponse
    {
        try {
            $message = $this->userVerify->verify($request, $user);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), (int) $exception->getCode());
        }

        VerifyUserEvent::dispatch($user);

        return $this->successResponse($message);
    }
}