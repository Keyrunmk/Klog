<?php

namespace App\Contracts;

interface CategoryContract
{
    public function createCategory(array $attributes): mixed;

    public function updateCategory(array $attributes, int $id): mixed;

    public function deleteCategory(int $id): mixed;

    public function findCategory(int $id): mixed;
}
