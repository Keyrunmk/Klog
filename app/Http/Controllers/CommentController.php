<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResouce;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        $attributes = request()->validate([
            "body" => ["required", "string"]
        ]);

        $post->comments()->create([
            "user_id" => Auth::user()->id,
            "body" => $attributes["body"],
        ]);

        return new CommentResource($post->comments);
    }
}
