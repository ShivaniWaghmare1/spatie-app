<?php

namespace App\Repositories\Role;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Role\RoleRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Role\RepoInterface\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::select('name', 'guard_name')->get()->toArray();
    }

    public function create(RoleRequest $request)
    {
        $role = Role::create(
            ['name' => $request->name]
        );

        return $role;
    }

    public function addPermissionsToRole($roleId, array $permissions)
    {
        $role = Role::findById($roleId);
        $data = $role->syncPermissions($permissions);
        return $data;
    }

    public function getRoleByID(int $id)
    {
        return Role::select('name')->find($id);
    }

    public function update(RoleRequest $data, int $id)
    {
        try {
            $role = Role::find($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        if ($role) {
            // update role name
            $data = $role->update($data->toArray());
        }
        return $data;
    }


    public function delete(int $id)
    {
        return Role::find($id)->delete();
    }
}
