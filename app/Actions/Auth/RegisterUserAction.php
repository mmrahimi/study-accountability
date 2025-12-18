<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(
        private IssueAuthTokenAction $issueAuthTokenAction
    ){}

    public function execute($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $this->issueAuthTokenAction->execute($user);
    }
}
