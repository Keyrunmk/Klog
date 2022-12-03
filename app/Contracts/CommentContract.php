<?php

namespace App\Contracts;

interface CommentContract
{
    public function createComment(array $attributes): mixed;
}