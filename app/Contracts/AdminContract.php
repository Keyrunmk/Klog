<?php

namespace App\Contracts;

interface AdminContract
{
    public function createAdmin(array $attibutes): mixed;

    public function deleteAdmin(int $id): mixed;
}
