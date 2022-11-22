<?php

namespace App\Repositories;

use App\Contracts\PostContract;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostContract
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function createPost(array $attributes): mixed
    {
        return $this->create($attributes);
    }

    public function updatePost(array $attributes, int $id): mixed
    {
        return $this->update($attributes, $id);
    }

    public function deletePost(int $id): mixed
    {
        return $this->delete($id);
    }

    public function findPost(int $id): mixed
    {
        return $this->findOneOrFail($id);
    }
}
