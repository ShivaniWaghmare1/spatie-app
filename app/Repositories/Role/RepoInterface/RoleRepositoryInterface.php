<?php

namespace App\Repositories\Role\RepoInterface;

use Illuminate\Http\Request;
use App\Http\Requests\Role\RoleRequest;

interface RoleRepositoryInterface
{
    public function getAll();

    public function create(RoleRequest $data);

    public function addPermissionsToRole($roleId, array $permissions);

    public function getRoleByID(int $id);

    public function update(RoleRequest $data, int $id);

    public function delete(int $id);
}
