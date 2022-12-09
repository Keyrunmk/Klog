<?php

namespace App\Services;

use App\Models\Post;
use App\Validations\PostReportValidation;
use Exception;
use Illuminate\Http\Request;

class PostReportService
{
    protected PostReportValidation $postReportValidation;

    public function __construct(PostReportValidation $postReportValidation)
    {
        $this->postReportValidation = $postReportValidation;
    }

    public function create(Post $post, Request $request): void
    {
        $attributes = $this->postReportValidation->validate($request);
        $attributes = array_merge($attributes, [
            "post_id" => $post->id,
            "user_id" => auth()->user()->id,
        ]);

        try {
            $post->postReports()->create($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
