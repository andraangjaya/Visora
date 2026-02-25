<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Authsservice;
use Illuminate\Http\Request;

class AuthsController extends BaseApiController
{

    public function register(Request $request, Authsservice $authsservice)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $authsservice->register($validated);

        return $this->success('user created', $validated, 201);
    }

    public function promote(User $user, Authsservice $authsservice)
    {
        return $this->success('user promoted', $authsservice->promote($user));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid Credentials'
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

}
