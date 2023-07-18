<?php

namespace App\Services\Admin;

use Exception;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\AuthRepository;

class AuthService
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login($credentials)
    {
        try {
            $authGuard = Auth::guard('web');
            if (!$authGuard->attempt($credentials)) {
                $data = 'Invalid Login Credentials';
            } else {
                $user = $authGuard->user();
                $token = $user->createToken('user')->accessToken;

                $data = [
                    'user' => $user,
                    'token' => $token,
                ];
            }
        } catch (Exception $e) {
            return $e;
        }

        return $data;
    }

    public function register($request)
    {
        // Create a new user record
        try {
            $user = $this->repository->create($request);
        } catch (Exception $e) {
            throw $e;
        }
        // Return the registration response data
        return $user;
    }
}
