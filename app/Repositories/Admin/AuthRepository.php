<?php

namespace App\Repositories\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class AuthRepository
{
    public function create(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request['name'],
                'mobile' => $request['mobile'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
        } catch (Exception $e) {
            throw $e;
        }
        return $user;
    }
}
