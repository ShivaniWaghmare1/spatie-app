<?php

namespace App\Services\Role;

use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Role\RoleRequest;
use App\Repositories\Role\RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleService
{
    protected $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function add(RoleRequest $request)
    {
        return $this->repository->create($request);
    }

    public function addPermissionsToRole($roleId, array $permissions)
    {
        return $this->repository->addPermissionsToRole($roleId, $permissions);
    }

    public function getRoleByID(int $id)
    {
        return $this->repository->getRoleByID($id);
    }

    public function update(RoleRequest $request, int $id)
    {
        try {
            $data = $this->repository->update($request, $id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        return $data;
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
    }
}
