<?php

namespace App\Services\Permission;

use App\Http\Requests\Permission\PermissionRequest;
use App\Repositories\Permission\PermissionRepository;


class PermissionService
{
    private $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createPermission(PermissionRequest $data)
    {
        return $this->repository->createPermission($data);
    }
}
