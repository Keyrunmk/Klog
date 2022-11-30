<?php

namespace App\Services;

use App\Models\Profile;
use Intervention\Image\Facades\Image;

class ProfileUpdate
{
    public function __invoke(Profile $profile, array $attributes): Profile
    {
        $profile->update([
            "title" => $attributes["title"],
            "description" => $attributes["description"],
            "url" => $attributes["url"]
        ]);

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