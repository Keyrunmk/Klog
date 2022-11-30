<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Exceptions\WebException;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request): mixed
    {
        // $attributes = $request->validated();
        try {
            $user = $this->userService->registerUser($request->all());
        } catch (Exception $e) {
            throw new WebException($e->getCode(), $e->getMessage());
        }

        return UserRegisteredEvent::dispatch($user);
    }
}
