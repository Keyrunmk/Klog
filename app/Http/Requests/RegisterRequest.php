<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends BaseRequest
{
    // protected $redirect = "user/error";

    // protected $redirectRoute = "user.error";

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "password" => Hash::make($this->password),
        ]);
    }
}
