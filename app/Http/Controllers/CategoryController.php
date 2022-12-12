<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends BaseController
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->middleware("adminRole:createCategory")->except("show");
    }

    public function show(int $category_id): JsonResponse|JsonResource
    {
        try {
            $category = $this->categoryService->show($category_id);
        } catch (Exception $e) {
            return $this->errorResponse("Category not found", (int) $e->getCode());
        }

        return new CategoryResource($category);
    }

    public function store(Request $request): JsonResponse|JsonResource
    {
        try {
            $category = $this->categoryService->create($request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new CategoryResource($category);
    }

    public function update(int $category_id, Request $request): JsonResponse|JsonResource
    {
        try {
            $category = $this->categoryService->update($category_id, $request);
        } catch (NotFoundException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new CategoryResource($category);
    }

    public function destroy(int $category_id): JsonResponse|JsonResource
    {
        try {
            $this->categoryService->delete($category_id);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return $this->successResponse("Category deleted");
    }
}
