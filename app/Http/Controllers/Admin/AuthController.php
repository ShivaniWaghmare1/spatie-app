<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Helpers\ResponseHelper;
use App\Services\Admin\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\Exceptions\AuthenticationException;

class AuthController extends Controller
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

        $this->service = $service;
    }

    /**
     * Log in a user with the provided credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = null;
        $code = "SUCCESS";
        try {
            $credentials = $request->only(['mobile', 'password']);
            $authGuard = Auth::guard('web');
            if (!$authGuard->attempt($credentials)) {
                throw new AuthenticationException;
            }
            $user = $authGuard->user();
            $token = $user->createToken('user')->accessToken;

            return response()->json([
                'token' => $token
            ]);
        } catch (ValidationException $e) {
            $code = "INVALID_DATA";
        } catch (AuthenticationException $e) {
            $code = "INVALID_CREDENTIALS";
        } catch (Exception $e) {
            return $e;
        }
        return ResponseHelper::respond(
            $code,
            $data,
        );
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = null;
        $code = "SUCCESS";
        // Create a new user record
        try {
            $data = $this->service->register($request);
        } catch (Exception $e) {
            $code = "DOES_NOT_EXIST";
        }
        return ResponseHelper::respond(
            $code,
            $data,
        );
    }
}
