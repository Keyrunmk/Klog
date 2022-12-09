<?php

namespace App\Services;

use App\Contracts\PostContract;
use App\Exceptions\ForbiddenException;
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

    public function index(int $user_id): Collection
    {
        try {
            // $posts = Cache::remember("posts", 1, function () use ($user_id) {
            //     return $this->postRepository->findBy(["user_id" => $user_id]);
            // });
            return $posts = $this->postRepository->findBy(["user_id" => $user_id]);
        } catch (Exception $e) {
            throw $e;
        }

        return $posts;
    }

    public function store(Request $request): Post
    {
        $attributes = $this->postValidation->validate($request);
        try {
            $location = UserLocation::getCountryName() ?? "world";
            $location_id = Location::where("country_name", $location)->value("id") ?? 1;

            $attributes = array_merge($attributes, [
                "user_id" => Auth::user()->id,
                "location_id" => $location_id,
            ]);

            if (($attributes["image"]) ?? false) {
                $imagePath = $this->getImagePath();
            }

            $post = $this->postRepository->create($attributes);

            if ($imagePath ?? false) {
                $this->postRepository->saveImage($post, $imagePath);
            }

            $this->postRepository->savePostLocation($post, $location);

            // Cache::forget("posts");
        } catch (Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function update(int $post_id, Request $request): Post
    {
        $attributes = $this->postValidation->validate($request);

        try {
            $this->postRepository->update($attributes, $post_id);
            $post = $this->postRepository->find($post_id);
            $post = $this->updateImage($post);
            // Cache::forget("posts");
        } catch (Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function delete(int $post_id)
    {
        try {
            $post = $this->postRepository->find($post_id);
            if (auth()->user()->cannot("update", $post)) {
                throw new ForbiddenException("Your are not authorized");
            }

            return $this->postRepository->delete($post_id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateImage(Post $post): Post
    {
        try {
            $imagePath = $this->getImagePath();
            $this->postRepository->updateImage($post, $imagePath);
            // Cache::forget("posts");
        } catch (Exception $e) {
            throw $e;
        }

        return $post;
    }

    public function getImagePath(): string
    {
        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        return $imagePath;
    }
}
