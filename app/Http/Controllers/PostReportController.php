<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostReportController extends Controller
{
    protected PostReportService $postReportService;

    public function __construct(PostReportService $postReportService)
    {
        $this->postReportService = $postReportService;
    }

    public function __invoke(Post $post, Request $request): JsonResponse
    {
        $post = $this->postReportService->create($post, $request);

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
