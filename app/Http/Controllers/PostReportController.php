<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostReportService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostReportController extends BaseController
{
    protected PostReportService $postReportService;

    public function __construct(PostReportService $postReportService)
    {
        $this->postReportService = $postReportService;
    }

    public function report(Post $post, Request $request): JsonResponse
    {
        try {
            $this->postReportService->create($post, $request);
            return $this->successResponse("Report submitted successfully");
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getCode(), $exception->getMessage());
        }

        return $this->errorResponse("Failed to submit report");
    }
}
