<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return $this->error('Unauthorized', 401);
        }

        $user = $request->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::now()->addMinutes(config('sanctum.expiration'))->toDateTimeString()
        ]);
    }
}
