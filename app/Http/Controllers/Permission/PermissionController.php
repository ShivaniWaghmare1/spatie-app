<?php

namespace App\Http\Controllers\Permission;

use Exception;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\Permission\PermissionService;
use App\Http\Requests\Permission\PermissionRequest;

class PermissionController extends Controller
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function store(PermissionRequest $request)
    {
        $data = null;
        $code = "SUCCESS";
        // Validation and input handling
        try {
            $data = $this->service->createPermission($request);

            return response()->json([
                'message' => 'Permission created successfully',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return $e;
        }
        return ResponseHelper::respond(
            $code,
            $data,
        );
    }
}
