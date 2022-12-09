<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Models\PostReport;
use App\Models\Role;
use App\Repositories\AdminRepository;
use App\Validations\AdminRegister;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public AdminRepository $adminRepository;
    public AdminRegister $validateRegister;
    public RoleService $roleService;
    public PermissionService $permissionService;
    public Role $roleModel;
    public array $permissionModels;

    public function __construct(
        AdminContract $adminRepository,
        AdminRegister $validateRegister,
        RoleService $roleService,
        PermissionService $permissionService
    ) {
        $this->adminRepository = $adminRepository;
        $this->validateRegister = $validateRegister;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function showReports()
    {
        return PostReport::all();
    }

    public function managerRegister(Request $request): mixed
    {
        $attributes = $this->validateRegister->run($request);

        DB::beginTransaction();
        try {
            foreach ($this->roleService->roles as $role) {
                if ($role->slug === "page-manager") {
                    $this->roleModel = $role;
                    break;
                }
            }

            foreach ($this->permissionService->permissions as $permission) {
                if ($permission->slug === "manage-users" || $permission->slug === "create-tasks") {
                    $this->permissionModels[] = $permission;
                }
            }

            $admin = $this->adminRepository->create($attributes);
            $this->roleModel->permissions()->saveMany($this->permissionModels);
            $admin->roles()->save($this->roleModel);
        } catch (Exception $e) {
            //implemnt db::intransaction() using macros
            DB::rollBack();
            return $e;
        }

        DB::commit();

        return $admin;
    }

    public function editorRegister(Request $request): mixed
    {
        $attributes = $this->validateRegister->run($request);
        $editor = $this->adminRepository->create($attributes);

        return $editor;
    }
}
