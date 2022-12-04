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
}
