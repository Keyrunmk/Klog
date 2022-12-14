<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Validations\CommentValidation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected CommentValidation $commentValidation;

    public function __construct(CommentValidation $commentValidation)
    {
        $this->commentValidation = $commentValidation;
    }

    public function __invoke(Post $post, Request $request): Comment
    {
        $attributes = $this->commentValidation->run($request);

        try {
            $post->comments()->create([
                "user_id" => Auth::user()->id,
                "body" => $attributes["body"],
            ]);
        } catch (Exception $e) {
            throw $e;
        }

        return $post->comments;
    }
}
