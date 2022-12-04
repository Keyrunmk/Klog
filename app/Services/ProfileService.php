<?php

namespace App\Services;

use App\Models\Profile;
use App\Validations\ProfileUpdate;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileService
{
    protected ProfileUpdate $profileValidate;

    public function __construct(ProfileUpdate $profileValidate)
    {
        $this->profileValidate = $profileValidate;
    }

    public function __invoke(Profile $profile, Request $request): Profile
    {
        $attributes = $this->profileValidate->run($request);

        $profile->update($attributes);

        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        $user = auth()->user();
        if (!$user->image()->update(["path" => $imagePath])){
            $user->image()->create(["path" => $imagePath]);
        }

        return $profile;
    }
}