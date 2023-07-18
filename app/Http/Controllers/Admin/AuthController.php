<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\Admin\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\LoginRequest;
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
        // $credentials = $request->validate([
        //     'mobile' => 'required|numeric|digits:10|exists:users',
        //     'password' => 'required|string',
        // ]);
        try {
            $data = $this->service->login($request);
            return response()->json([
                "status" => 200,
                "message" => "OK",
                "data" => [
                    "token" => $data['token'],
                ],
            ], 200);
            //}
            // catch (Exception $e) {
            //     return response()->json([
            //         "status" => 402,
            //         "message" => "Invalid credentials",
            //         "data" => null
            //     ]);
        } catch (ValidationException $e) {
            $code = "INVALID DATA";
        } catch (AuthenticationException $e) {
            $code = "INVALID CREDENTIALS";
        } catch (UnauthorizedException $e) {
            $code = "UNAUTHORISED";
        } catch (Exception $e) {
            $code = "DOES_NOT_EXIST";
        }
        // return ResponseHelper::respond(
        //     $code,
        //     $data,
        // );
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'password' => 'required|string',
        ]);

        // Create a new user record
        try {
            $data = $this->service->register($request);
        } catch (ValidationException $e) {
            $code = "INVALID DATA";
        } catch (Exception $e) {
            $code = "DOES_NOT_EXIST";
        }

        return response()->json([
            'message' => 'User created successfully',
            'data' => $data
        ]);
        // return ResponseHelper::respond(
        //     $code,
        //     $data,
        // );
    }
}
