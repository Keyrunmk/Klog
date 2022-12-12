<?php

namespace App\Services;

use App\Contracts\ProfileContract;
use App\Exceptions\NotFoundException;
use App\Repositories\ProfileRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FollowService
{
    protected ProfileRepository $profileRepository;

    public function __construct(ProfileContract $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function followProfile(int $profile_id): string
    {
        try {
            $profile = $this->profileRepository->findOneOrFail($profile_id);
            $user = $profile->user;
            //todo - test for profile
            $response = auth()->user()->following()->toggle($user);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException();
        }catch (Exception $e) {
            throw $e;
        }

        if (!empty($response["attached"])) {
            return "Following profile id " . $response["attached"][0];
        }

        return "Unfollowed profile id " . $response["detached"][0];
    }
}
