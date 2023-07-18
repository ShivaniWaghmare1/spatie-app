<?php

namespace App\Services\Role;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Role\RoleRequest;
use App\Repositories\Role\RepoInterface\RoleRepositoryInterface;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function add(Request $data)
    {
        return $this->roleRepository->create($data);
    }

    public function getRoleByID($id)
    {
        return $this->roleRepository->getRoleByID($id);
    }

    public function update(RoleRequest $request, int $id)
    {
        $data = new RoleRequest([
            'name' => $request->name,
        ]);

        return $this->roleRepository->update($data, $id);
    }

    public function delete(Role $role)
    {
        $this->roleRepository->delete($role);
    }
}
