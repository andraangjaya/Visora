<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthService
{
    public function register(array $data): User
    {
        return User::create($data);
    }

    public function promote(User $user): User
    {
        $user->update(['role' => 'admin']);
        return $user;
    }

    public function forgotPassword(string $email)
    {
        return Password::sendResetLink(
            [
                'email' => $email,
            ]);

    }

    public function resetPassword(array $data)
    {
        return Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
    }

}
