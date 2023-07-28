<?php

namespace App\Repositories\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use App\Repositories\Admin\RepoInterface\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function create(Request $request)
    {
        try {

            // Create the user
            $user = User::create([
                'name' => $request['name'],
                'mobile' => $request['mobile'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
            // Assign the role to the user
            $role = Role::findByName($request['role']);
            if ($role) {
                $user->assignRole($role);
            } else {
                throw new NotFound;
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $user;
    }
}
