<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function __invoke(Post $post, array $attributes): Comment
    {
        $post->comments()->create([
            "user_id" => Auth::user()->id,
            "body" => $attributes["body"],
        ]);

        return $post->comments;
    }
}