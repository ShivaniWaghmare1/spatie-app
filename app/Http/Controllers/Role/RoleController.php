<?php

namespace App\Http\Controllers\Role;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\Role\RoleService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Role\RoleRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Spatie\Permission\Exceptions\UnauthorizedException as ExceptionsUnauthorizedException;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = null;
        $code = "SUCCESS";
        try {
            // Check if the authenticated user has the 'create_role' permission
            if (Auth::user()->checkHasPermissionTo('list_role')) {
                $data = $this->service->getAll();
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                ]);
            }
        } catch (Exception $e) {
            return $e;
        }
        return ResponseHelper::respond(
            $code,
            $data,
        );
    }

    public function store(RoleRequest $request)
    {
        $data = null;
        $code = "SUCCESS";
        // Validation and input handling
        try {
            // Check if the authenticated user has the 'create_role' permission
            if (Auth::user()->checkHasPermissionTo('create_role')) {
                $data = $this->service->add($request);

                return response()->json([
                    'message' => 'Success ok',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                ]);
            }
        } catch (Exception $e) {
            return $e;
        }
        return ResponseHelper::respond(
            $code,
            $data,
        );
    }

    public function addPermissionsToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required|array',
        ]);
        // Get the authenticated user
        $user = Auth::user();

        // Check if the authenticated user has the 'create_role_permission' permission
        if ($user->checkHasPermissionTo('create_role_permission')) {
            $permissions = $request->input('permission');
            $data = $this->service->addPermissionsToRole($roleId, $permissions);
            return response()->json([
                'message' => 'Permissions added to the role successfully',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ]);
        }
    }

    public function show(int $id)
    {
        $role = $this->service->getRoleByID($id);

        return response()->json($role);
    }

    public function update(RoleRequest $request, int $id)
    {
        // Validation and input handling
        try {
            $role = $this->service->update($request, $id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        return response()->json($role);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return response()->json(null, 204);
    }
}
