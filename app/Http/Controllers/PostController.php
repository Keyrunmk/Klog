<?php

namespace App\Http\Controllers;

use App\Contracts\PostContract;
use App\facades\UserLocation;
use App\Http\Resources\PostResource;
use App\Models\Location;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostContract $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store()
    {
        $location = Location::where("location", UserLocation::getCountryName())->first();
        if (! $location) {
            $location = Location::create(["location" => UserLocation::getCountryName()]);
        }

        $attributes = array_merge($this->validatePost(), [
            "user_id" => Auth::user()->id,
            "location_id" => $location->id,
        ]);

        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        $post = $this->postRepository->createPost($attributes);

        $post->image()->create(["path" => $imagePath]);

        return new PostResource($post);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        $this->postRepository->updatePost($attributes, $post->id);

        $post = $this->postRepository->findPost($post->id);

        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        $post->image()->update(["path" => $imagePath]);

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $post = $this->postRepository->deletePost($post->id);

        return new PostResource($post);
    }

    public function validatePost(?Post $post = null)
    {
        $post ??= new Post();

        return request()->validate([
            "title" => ["required", "max:255"],
            "slug" => ["required", Rule::unique("posts", "slug")->ignore($post)],
            "body" => ["required", "max:255"],
            "category_id" => ["required", Rule::exists("categories", "id")],
            "image" => ["nullable", "image"],
        ]);
    }
}
