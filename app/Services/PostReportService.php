<?php

namespace App\Services;

use App\Models\Post;
use App\Validations\PostReportValidation;
use Illuminate\Http\Request;

class PostReportService
{
    protected PostReportValidation $postReportValidation;

    public function __construct(PostReportValidation $postReportValidation)
    {
        $this->postReportValidation = $postReportValidation;
    }

    public function create(Post $post, Request $request)
    {
        $attributes = $this->postReportValidation->run($request);
        $attributes = array_merge($request->validated(), [
            "post_id" => $post->id,
            "user_id" => auth()->user()->id,
        ]);

        $post = $post->postReports()->create($attributes);

        return $post;
    }
}
