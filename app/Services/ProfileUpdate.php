<?php

namespace App\Services;

use App\Models\Profile;
use Intervention\Image\Facades\Image;

class ProfileUpdate
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function __invoke(Profile $profile, array $attributes): Profile
    {
        $profile->update([
            "title" => $attributes["title"],
            "description" => $attributes["description"],
            "url" => $attributes["url"]
        ]);

        $imagePath = $this->imageService->processImage();

        $user = auth()->user();
        if (!$user->image()->update(["path" => $imagePath])){
            $user->image()->create(["path" => $imagePath]);
        }

        return $profile;
    }
}