<?php

namespace App\Repositories\Role\RepoInterface;

use App\Http\Requests\Role\RoleRequest;
use App\Http\Requests\Permission\PermissionRequest;

interface PermissionRepositoryInterface
{

    public function create(PermissionRequest $data);
}
