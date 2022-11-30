<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostReportRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostReportController extends Controller
{
    public function __invoke(Post $post, PostReportRequest $request): JsonResponse
    {
        $attributes = array_merge($request->validated(), [
            "post_id" => $post->id,
            "user_id" => auth()->user()->id,
        ]);

        $post = $post->postReports()->create($attributes);

        if ($post) {
            return response()->json([
                "status" => "Reported successfully",
                "post" => $post->title,
            ]);
        }

        return response()->json([
            "status" => "Post report failed",
        ]);
    }
}
