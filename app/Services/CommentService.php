<?php

namespace App\Services;

use App\Exceptions\ForbiddenException;
use App\Models\Comment;
use App\Models\Post;
use App\Validations\CommentValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected CommentValidation $commentValidation;

    public function __construct(CommentValidation $commentValidation)
    {
        $this->commentValidation = $commentValidation;
    }

    public function create(Post $post, Request $request): Comment
    {
        $attributes = $this->commentValidation->validate($request);

        $post->comments()->create([
            "user_id" => Auth::user()->id,
            "body" => $attributes["body"],
        ]);

        return $post->comments;
    }

    public function destroy(Post $post, Comment $comment): void
    {
        if (auth()->user()->can("delete", $post) || auth()->user()->can("delete", $comment)) {
            $comment->delete();
        }

        throw new ForbiddenException();
    }
}
