<?php

namespace App\Contracts;

interface PostContract
{
    public function createPost(array $attributes): mixed;

    public function updatePost(array $attributes, int $id): mixed;

    public function deletePost(int $id): mixed;

    public function findPost(int $id): mixed;
}
