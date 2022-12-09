<?php

namespace App\Services;

use App\Contracts\ProfileContract;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use App\Validations\ProfileUpdate;
use Exception;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileService
{
    protected ProfileUpdate $profileValidate;
    protected ProfileRepository $profileRepository;

    public function __construct(ProfileUpdate $profileValidate, ProfileContract $profileRepository)
    {
        $this->profileValidate = $profileValidate;
        $this->profileRepository = $profileRepository;
    }

    public function find(int $profile_id): Profile
    {
        try {
            return $this->profileRepository->find($profile_id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(Profile $profile, Request $request): Profile
    {
        try {
            $attributes = $this->profileValidate->validate($request);

            $profile->update($attributes);

            if ($request->image) {
                $imagePath = request("image")->store("uploads", "public");
                $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
                $image->save();
            }

            $user = auth()->user();
            if ($imagePath ?? false) {
                if (!$user->image()->update(["path" => $imagePath])) {
                    $user->image()->create(["path" => $imagePath]);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $profile;
    }
}
