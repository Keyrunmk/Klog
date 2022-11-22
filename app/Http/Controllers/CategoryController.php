<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryContract;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store()
    {
        $attributes = request()->validate([
            "name" => ["string", "required", Rule::unique("categories", "name")],
            "slug" => ["string", "required", Rule::unique("categories", "slug")],
        ]);

        $category = $this->categoryRepository->createCategory($attributes);

        return new CategoryResource($category);
    }

    public function update(Category $category)
    {
        $attributes = request()->validate([
            "name" => ["required", "string", Rule::unique("categories", "name")],
            "slug" => ["required", "string", Rule::unique("categories", "slug")],
        ]);

        $this->categoryRepository->updateCategory($attributes, $category->id);

        $category = $this->categoryRepository->findCategory($category->id);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->deleteCategory($category->id);

        return new CategoryResource($category);
    }
}
