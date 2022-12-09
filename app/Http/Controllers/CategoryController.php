<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryContract;
use App\Exceptions\ForbiddenException;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class CategoryController extends BaseController
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        if (auth()->guard("admin-api")->user()->cannot("createCategory", Admin::class)) {
            throw new ForbiddenException("Only admins can crud on category");
        }
    }

    public function show(int $category_id): JsonResponse|JsonResource
    {
        try {
            $category = $this->categoryRepository->find($category_id);
        } catch (Exception $e) {
            return $this->errorResponse("Failed to find category", (int) $e->getCode());
        }

        return new CategoryResource($category);
    }

    public function store(): JsonResponse|JsonResource
    {
        $attributes = request()->validate([
            "name" => ["string", "required", Rule::unique("categories", "name")],
            "slug" => ["string", "required", Rule::unique("categories", "slug")],
        ]);

        try {
            $category = $this->categoryRepository->create($attributes);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new CategoryResource($category);
    }

    public function update(int $category_id): JsonResponse|JsonResource
    {
        $attributes = request()->validate([
            "name" => ["required", "string", Rule::unique("categories", "name")],
            "slug" => ["required", "string", Rule::unique("categories", "slug")],
        ]);

        try {
            $this->categoryRepository->update($attributes, $category_id);

        $category = $this->categoryRepository->find($category_id);
        } catch (Exception|Error $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new CategoryResource($category);
    }

    public function destroy(int $category_id): JsonResponse|JsonResource
    {
        try {
            $this->categoryRepository->delete($category_id);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return $this->successResponse("Category deleted");
    }
}
