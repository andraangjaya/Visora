<?php

namespace App\Services;

use App\Models\User;

class Authsservice
{
    public function register(array $data): User{
        return User::create($data);
    }

    public function promote(User $user): User{
        $user->update(['role' => 'admin']);
        return $user;
    }

}
