<?php

namespace App\Repositories\Role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Role\RoleRequest;
use App\Repositories\Role\RepoInterface\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::select('name', 'guard_name')->get()->toArray();
    }

    public function create(Request $data)
    {
        $role = new Role();
        $role->name = $data->name;
        $role->save();

        return $role;
    }

    public function getRoleByID($id)
    {
        return Role::select('name')->findOrFail($id);
    }

    public function update(RoleRequest $data, int $id)
    {
        $data = Role::find($id)->update($data->toArray());

        return $data;
    }

    public function delete(Role $role)
    {
        $role->delete();
    }
}
