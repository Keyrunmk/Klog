<?php

namespace App\Contracts;

interface PostReport
{
    public function createReport(array $attributes): mixed;
}