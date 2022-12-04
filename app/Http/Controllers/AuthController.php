<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Services\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    protected UserVerify $userVerify;

    public function __construct(UserVerify $userVerify)
    {
        $this->userVerify = $userVerify;
    }

    public function __invoke(Request $request): JsonResource
    {
        $message = $this->userVerify->__invoke($request);

        return new BaseResource([
            "message" => $message,
        ]);
    }
}
