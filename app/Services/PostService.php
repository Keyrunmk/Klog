<?php

namespace App\Services;

use App\Contracts\PostContract;
use App\facades\UserLocation;
use App\Models\Location;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PostService
{
    public PostRepository $postRepository;

    public function __construct(PostContract $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(): Post
    {
        return $this->postRepository->allPosts(auth()->user()->id);
    }

    public function store(array $attributes): Post
    {
        $location = UserLocation::getCountryName();
        $location_id = Location::where("country_name", $location)->value("id");

        $attributes = array_merge($attributes, [
            "user_id" => Auth::user()->id,
            "location_id" => $location_id,
        ]);

        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        $post = $this->postRepository->createPost($attributes);

        $post->image()->create(["path" => $imagePath]);

        $post->location()->create(["country_name" => $location]);

        return $post;
    }

    public function update(Post $post, array $attributes): Post
    {
        $this->postRepository->updatePost($attributes, $post->id);

        $post = $this->postRepository->findPost($post->id);

        $post = $this->updateImage($post);

        return $post;
    }

    public function updateImage(Post $post): Post
    {
        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        $post->image()->update(["path" => $imagePath]);

        return $post;
    }
}
