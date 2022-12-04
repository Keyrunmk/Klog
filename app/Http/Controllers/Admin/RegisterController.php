<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Services\Admin\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterController extends Controller
{
    public AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        $this->middleware("role:page-admin");
    }

    public function __invoke(Request $request): JsonResource
    {
        $data = $this->authenticationService->register($request);

        return new AdminResource($data["admin"], $data["token"]);
    }
}
