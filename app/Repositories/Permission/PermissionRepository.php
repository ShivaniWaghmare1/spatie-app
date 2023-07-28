<?php

namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permission\PermissionRequest;

class PermissionRepository
{
    public function createPermission(PermissionRequest $data)
    {
        return Permission::create(
            [
                'name' => $data->name
            ]
        );
    }
}
