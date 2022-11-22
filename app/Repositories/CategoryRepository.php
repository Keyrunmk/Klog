<?php

namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryContract
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function createCategory(array $attributes): mixed
    {
        return $this->create($attributes);
    }

    public function updateCategory(array $attributes, int $id): mixed
    {
        return $this->update($attributes, $id);
    }

    public function deleteCategory(int $id): mixed
    {
        return $this->delete($id);
    }

    public function findCategory(int $id): mixed
    {
        return $this->findOneOrFail($id);
    }
}
