<?php

namespace App\Repositories\Role\RepoInterface;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Role\RoleRequest;

interface RoleRepositoryInterface
{
    public function getAll();

    public function create(Request $data);

    public function getRoleByID(int $id);

    public function update(RoleRequest $data, int $id);

    public function delete(Role $role);
}
