<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AuthsController extends BaseApiController
{
    public function register(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = $authService->register($validated);
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function promote(User $user, AuthService $authService)
    {
        return $this->success('user promoted', $authService->promote($user));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid Credentials'
            ], 401);
        }

        $user = auth()->user();
        $user->tokens()->delete();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success('User logged out');
    }

    public function forgotPassword(Request $request, AuthService $authService)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = $authService->forgotPassword($request->email);

        $message = match ($status) {
            Password::RESET_LINK_SENT => 'Reset link sent successfully',
            Password::RESET_THROTTLED => 'Too many reset requests, please try again in 5 minutes.',
            Password::INVALID_USER => 'Invalid email address'
        };

        if ($status === Password::RESET_LINK_SENT) {
            return $this->success($message);
        } else {
            return $this->error($message);
        }
    }

    public function resetPassword(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = $authService->resetPassword($validated);

        if ($status === Password::PASSWORD_RESET) {
            return $this->success('Password reset successful');
        }

        return $this->error('Password reset failed');
    }
}
