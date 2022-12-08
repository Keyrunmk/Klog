<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request): mixed
    {
        try {
            $user = $this->userService->register($request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getCode(), $e->getMessage());
        }

        return UserRegisteredEvent::dispatch($user);
    }
}
