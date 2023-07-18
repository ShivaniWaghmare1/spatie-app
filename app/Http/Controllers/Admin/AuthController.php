<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Services\Admin\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use Illuminate\Validation\ValidationException;

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
        try {
            $credentials = $request->only(['mobile', 'password']);
            $data = $this->service->login($credentials);

            return $data;
        } catch (Exception $e) {
            return $e;
        }

        // try {
        //     $data = $this->service->login($request);
        //     return response()->json([
        //         "status" => 200,
        //         "message" => "OK",
        //         "data" => [
        //             "token" => $data['token'],
        //         ],
        //     ], 200);
        // } catch (ValidationException $e) {
        //     $code = "INVALID DATA";
        // } catch (AuthenticationException $e) {
        //     $code = "INVALID CREDENTIALS";
        // } catch (UnauthorizedException $e) {
        //     $code = "UNAUTHORISED";
        // } catch (Exception $e) {
        //     $code = "DOES_NOT_EXIST";
        // }
        // return ResponseHelper::respond(
        //     $code,
        //     $data,
        // );
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        // Create a new user record
        try {
            $data = $this->service->register($request);
            return response()->json([
                'message' => 'User created successfully',
                'data' => $data
            ]);
        } catch (ValidationException $e) {
            $code = "INVALID DATA";
        } catch (Exception $e) {
            $code = "DOES_NOT_EXIST";
        }
        // return ResponseHelper::respond(
        //     $code,
        //     $data,
        // );
    }
}
