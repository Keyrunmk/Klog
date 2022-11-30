<?php

namespace App\Contracts;

interface TagContract
{
    public function storeTags(array $attributes): mixed;
}