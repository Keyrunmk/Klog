<?php

namespace App\Repositories;

use App\Contracts\PostContract;
use App\Models\Post;
use Exception;

class PostRepository extends BaseRepository implements PostContract
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function allPosts(int $userId): mixed
    {
        try {
            return $this->all()->where("user_id", $userId);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createPost(array $attributes): mixed
    {
        try {
            return $this->create($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updatePost(array $attributes, int $id): mixed
    {
        try {
            return $this->update($attributes, $id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deletePost(int $id): mixed
    {
        try {
            return $this->delete($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findPost(int $id): mixed
    {
        try {
            return $this->findOneOrFail($id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
