<?php

namespace App\Services;

use App\Contracts\UserContract;
use App\facades\UserLocation;
use App\Http\Resources\BaseResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Validations\UserLogin;
use App\Validations\UserRegister;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class UserService
{
    public UserRepository $userRepository;
    public UserRegister $validateRegister;
    public UserLogin $validateLogin;

    public function __construct(UserContract $userRepository, UserRegister $validateRegister, UserLogin $validateLogin)
    {
        $this->userRepository = $userRepository;
        $this->validateRegister = $validateRegister;
        $this->validateLogin = $validateLogin;
    }

    public function register(Request $request): User|Exception
    {
        $attributes = $this->validateRegister->run($request);
        $attributes["password"] = Hash::make($attributes["password"]);

        try {
            $user = $this->userRepository->create($attributes);
            $this->setLocation($user);
        } catch (Exception $e) {
            throw $e;
        }

        return $user;
    }

    public function login(Request $request): JsonResource|array
    {
        $attributes = $this->validateLogin->run($request);

        try {
            $token = Auth::attempt($attributes);
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

    public function logout()
    {
        try {
            Auth::logout();
        } catch (JWTException $e) {
            return new BaseResource(['message' => $e->getMessage()]);
        }
    }

    public function refreshToken(): string|HttpResponse
    {
        try {
            $newToken = Auth::refresh();
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return $newToken;
    }

    public function setLocation(User $user): JsonResource
    {
        $userLocation = UserLocation::getCountryName();
        $user->location()->create(["country_name" => $userLocation]);

        return new BaseResource([
            "location" => "User location set successfully",
        ]);
    }
}