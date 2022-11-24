<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract;
use App\Events\UserRegisteredEvent;
use App\facades\UserLocation;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register()
    {
        request()->validate([
            "name" => ["required", "string", "max:255"],
            "username" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:users,email"],
            "password" => ["required", "string", "min:8"],
            "status" => ["required", "string", Rule::in(["active"])],
        ]);

        $user = $this->userRepository->createUser([
            "name" => request("name"),
            "username" => request("username"),
            "email" => request("email"),
            "password" => Hash::make(request("password")),
            "status" => request("status"),
        ]);

        $user->location()->create(["country_name" => UserLocation::getCountryName()]);

        return UserRegisteredEvent::dispatch($user);
    }
}
