<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store()
    {
        $attributes = array_merge($this->validatePost(), [
            'user_id' => Auth::user()->id,
        ]);

        $post = Post::create($attributes);

        return new PostResource($post);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        $post->update($attributes);

        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return new PostResource($post);
    }

    public function validatePost(?Post $post = null)
    {
        $post ??= new Post();

        return request()->validate([
            "title" => ["required", "max:255"],
            "slug" => ["required", Rule::unique("posts", "slug")->ignore($post)],
            "body" => ["required", "max:255"],
            "category_id" => ["required", Rule::exists("categories", "id")],
        ]);
    }
}
