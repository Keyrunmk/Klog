<?php

namespace App\Services;

use App\Contracts\UserContract;
use App\facades\UserLocation;
use App\Http\Resources\BaseResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class UserService
{
    public UserRepository $userRepository;

    public function __construct(UserContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $attributes): User|Exception
    {
        try {
            $user = $this->userRepository->createUser($attributes);
            $this->setUserLocation($user);
        } catch (Exception $e) {
            throw $e;
        }

        return $user;
    }

    public function loginUser(array $credentials): JsonResource|array
    {
        try {
            $token = Auth::attempt($credentials);
        } catch (JWTException $e) {
            return new BaseResource(['message' => $e->getMessage()]);
        }

        if (!$token) {
            return new BaseResource([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        };

        return [
            "user" => Auth::user(),
            "token" => $token,
        ];
    }

    public function logoutUser()
    {
        try {
            Auth::logout();
        } catch (JWTException $e) {
            return new BaseResource(['message' => $e->getMessage()]);
        }
    }

    public function refreshUserToken(): string|HttpResponse
    {
        try {
            $newToken = Auth::refresh();
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return $newToken;
    }

    public function setUserLocation(User $user): JsonResource
    {
        $userLocation = UserLocation::getCountryName();
        $user->location()->create(["country_name" => $userLocation]);

        return new BaseResource([
            "location" => "User location set successfully",
        ]);
    }
}