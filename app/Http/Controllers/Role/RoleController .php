<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $roles = $this->service->getAll();

        return response()->json($roles);
    }

    public function store(Request $data)
    {
        // Validation and input handling

        $role = $this->service->add($data);

        return response()->json($role, 201);
    }

    public function show($id)
    {
        $role = $this->service->getRoleByID($id);

        return response()->json($role);
    }

    public function update(RoleRequest $request, int $id)
    {
        // Validation and input handling

        $role = $this->service->update($request, $id);

        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = $this->service->getRoleByID($id);
        $this->service->delete($role);

        return response()->json(null, 204);
    }
}
