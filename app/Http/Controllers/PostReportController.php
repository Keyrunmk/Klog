<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
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
            if ($this->postReportService->create($post, $request)) {
                return $this->successResponse("Report submitted successfully");
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getCode(), $e->getMessage());
        }

        return $this->errorResponse("Failed to submit report");
    }
}
