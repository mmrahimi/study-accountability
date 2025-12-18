<?php

namespace App\Http\Controllers;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\RegisterUserRequest;

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
}
