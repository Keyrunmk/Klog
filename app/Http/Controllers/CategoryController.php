<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
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

        $category = Category::create($attributes);

        return new CategoryResource($category);
    }

    public function update(Category $category)
    {
        $attributes = request()->validate([
            "name" => ["required", "string", Rule::unique("categories", "name")],
            "slug" => ["required", "string", Rule::unique("categories", "slug")],
        ]);

        $category->update($attributes);

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return new CategoryResource($category);
    }
}
