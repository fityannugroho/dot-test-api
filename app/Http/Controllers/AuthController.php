<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'statusCode' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'statusCode' => 200,
            'message' => 'success',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::now()->addMinutes(config('sanctum.expiration'))->toDateTimeString()
            ]
        ], 200);
    }
}
