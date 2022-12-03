<?php

namespace App\Services;

use App\Contracts\PostContract;
use App\facades\UserLocation;
use App\Models\Location;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public PostRepository $postRepository;
    public ImageService $imageService;

    public function __construct(PostContract $postRepository, ImageService $imageService)
    {
        $this->postRepository = $postRepository;
        $this->imageService = $imageService;
    }

    public function index(): Collection|Post
    {
        return $this->postRepository->allPosts(auth()->user()->id);
    }

    public function store(array $attributes): Post
    {
        $location = UserLocation::getCountryName();
        $location_id = Location::where("country_name", $location)->value("id");

        $attributes = array_merge($attributes, [
            "user_id" => Auth::guard("api-jwt")->user()->id,
            "location_id" => $location_id,
        ]);

        $imagePath = $this->imageService->processImage();

        $post = $this->postRepository->createPost($attributes);

        $post->image()->create(["path" => $imagePath]);

        $post->location()->create(["country_name" => $location]);

        return $post;
    }

    public function update(Post $post, array $attributes): Post
    {
        $this->postRepository->updatePost($attributes, $post->id);

        $post = $this->postRepository->findPost($post->id);

        $imagePath = $this->imageService->processImage();

        $post->image()->update(["path" => $imagePath]);

        return $post;
    }

    public function delete(Post $post): bool
    {
        return $this->postRepository->deletePost($post->id);
    }
}
