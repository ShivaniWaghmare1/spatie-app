<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    // Role routes
    // Route::resource('roles', 'RoleController')->except(['create', 'edit']);
    // Route::resource('roles', RoleController::class);

    // Permission routes
    // Route::resource('permissions', 'PermissionController')->except(['create', 'edit']);
    // Route::resource('permissions', PermissionController::class);
});
