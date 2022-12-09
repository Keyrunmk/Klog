<?php

namespace App\Repositories;

use App\Contracts\PostContract;
use App\Models\Post;
use Exception;
use Intervention\Image\Facades\Image;

class PostRepository extends BaseRepository implements PostContract
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function saveImage(Post $post,Image $imagePath): void
    {
        try {
            $post->image()->create(["path" => $imagePath]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function savePostLocation(Post $post, string $location): void
    {
        try {
            $post->location()->create(["country_name" => $location]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateImage(Post $post, string $imagePath): void
    {
        try {
            $post->image()->update(["path" => $imagePath]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
