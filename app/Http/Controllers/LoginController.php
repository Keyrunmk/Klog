<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\LoginResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware("guest:api")->only("login");
    }

    public function login(Request $request): JsonResource
    {
        $data = $this->userService->login($request);

        if ($data instanceof JsonResource) {
            return $data;
        }

        return new LoginResource($data["user"], $data["token"]);
    }

    public function logout(): JsonResource
    {
        $this->userService->logout();

        return new BaseResource([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

    public function refreshToken(): JsonResource
    {
        $newToken = $this->userService->refreshToken();

        return new LoginResource(Auth::user(), $newToken);
    }
}
