<?php

namespace App\Services;

use App\Contracts\TagContract;
use App\Repositories\TagRepository;

class TagService
{
    protected TagRepository $tagRepository;

    public function __construct(TagContract $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }
}