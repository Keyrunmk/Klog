<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileRepository;
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Profile $profile): ProfileResource
    {
        return new ProfileResource($profile);
    }

    public function update(Profile $profile, Request $request): mixed
    {
        try {
            $profile = $this->profileService->__invoke($profile, $request);
        } catch (Exception $e) {
            throw new WebException($e->getCode() ,$e->getMessage());
        }

        return new ProfileResource($profile);
    }
}
