<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    protected $profileRepository;
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(int $profile_id): ProfileResource
    {
        try {
            $profile = $this->profileService->find($profile_id);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int)$e->getCode());
        }
        return new ProfileResource($profile);
    }

    public function update(int $profile_id, Request $request): mixed
    {
        try {
            $profile = $this->profileService->find($profile_id);
            $this->authorize("update", $profile);
            $profile = $this->profileService->update($profile, $request);
        } catch (NotFoundException $e) {
            return $this->errorResponse("No profile with given id", (int) $e->getCode());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int)$e->getCode());
        }

        return new ProfileResource($profile);
    }
}
