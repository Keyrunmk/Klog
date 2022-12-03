<?php

namespace App\Repositories;

use App\Contracts\CommentContract;
use App\Models\Comment;
use Exception;

class CommentRepository extends BaseRepository implements CommentContract
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function createComment(array $attributes): mixed
    {
        try {
            return $this->createComment($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }
}