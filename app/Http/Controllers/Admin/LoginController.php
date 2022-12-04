<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\LoginResource;
use App\Services\Admin\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginController extends Controller
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        // $this->middleware("guest:admin-api");
    }

    public function login(Request $request): JsonResource
    {
        $data = $this->authenticationService->login($request);

        return new LoginResource($data["admin"], $data["token"]);
    }

    public function logout(): JsonResource
    {
        $this->authenticationService->logout();

        return new BaseResource([
            "status" => "Logged out successfully",
        ]);
    }
}
