<?php

namespace App\Services;

use App\Contracts\PostContract;
use App\facades\UserLocation;
use App\Models\Location;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Validations\PostValidation;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class PostService
{
    protected PostRepository $postRepository;
    protected PostValidation $postValidation;

    public function __construct(PostContract $postRepository, PostValidation $postValidation)
    {
        $this->postRepository = $postRepository;
        $this->postValidation = $postValidation;
    }

    public function index(): Collection
    {
        try {
            $posts = Cache::rememberForever("posts", function () {
                return $this->postRepository->findBy(["id" => auth()->user()->id]);
            });
            return $posts;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(Request $request): Post
    {
        $attributes = $this->postValidation->run($request);
        try {
            $location = UserLocation::getCountryName() ?? "world";
            $location_id = Location::where("country_name", $location)->value("id") ?? 1;

            $attributes = array_merge($attributes, [
                "user_id" => Auth::user()->id,
                "location_id" => $location_id,
            ]);

            if (($attributes["image"]) ?? false) {
                $imagePath = request("image")->store("uploads", "public");
                $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
                $image->save();
            }

            $post = $this->postRepository->create($attributes);

            if ($imagePath ?? false) {
                $post->image()->create(["path" => $imagePath]);
            }

            $post->location()->create(["country_name" => $location]);

            Cache::forget("posts");
        } catch (Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function update(Post $post, Request $request): Post
    {
        $attributes = $this->postValidation->run($request);

        try {
            $this->postRepository->update($attributes, $post->id);
            $post = $this->postRepository->find($post->id);
            $post = $this->updateImage($post);
            Cache::forget("posts");
        } catch (Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function updateImage(Post $post): Post
    {
        try {
            $imagePath = request("image")->store("uploads", "public");
            $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
            $image->save();
            $post->image()->update(["path" => $imagePath]);
            Cache::forget("posts");
        } catch (Exception $e) {
            throw $e;
        }

        return $post;
    }
}
