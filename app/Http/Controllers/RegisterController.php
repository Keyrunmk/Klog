<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Exceptions\WebException;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Exception;

class RegisterController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(RegisterRequest $request): mixed
    {
        $attributes = $request->validated();

        try {
            $user = $this->userService->registerUser($attributes);
        } catch (Exception $e) {
            throw new WebException($e->getCode(), $e->getMessage());
        }

        return UserRegisteredEvent::dispatch($user);
    }
}
