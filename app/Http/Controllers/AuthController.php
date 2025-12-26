<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request, RegisterUserAction $action)
    {
        $token = $action->execute($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'token' => $token,
        ], 201);
    }

    public function login(LoginUserRequest $request, LoginUserAction $action)
    {
        $token = $action->execute($request->validated());

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
        ]);
    }

    public function logout(Request $request, LogoutUserAction $action)
    {
        $action->execute($request->user());

        return response()->json([
            'message' => 'User logged out successfully',
        ]);
    }
}
