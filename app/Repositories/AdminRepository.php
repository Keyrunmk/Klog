<?php

namespace App\Repositories;

use App\Contracts\AdminContract;
use App\Models\Admin;

class AdminRepository extends BaseRepository implements AdminContract
{
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }

    public function createAdmin(array $attibutes): mixed
    {
        return $this->create($attibutes);
    }

    public function deleteAdmin(int $id): mixed
    {
        return $this->delete($id);
    }
}