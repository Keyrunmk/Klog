<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileUpdate;

class ProfileController extends Controller
{
    protected ProfileUpdate $profileUpdate;

    public function __construct(ProfileUpdate $profileUpdate)
    {
        $this->profileUpdate = $profileUpdate;
    }

    public function show(Profile $profile): ProfileResource
    {
        return new ProfileResource($profile);
    }

    public function update(Profile $profile, ProfileRequest $request): mixed
    {
        $attributes = $request->validated();

        $profile = $this->profileUpdate->__invoke($profile, $attributes);

        return new ProfileResource($profile);
    }
}
