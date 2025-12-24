<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(
        private IssueAuthTokenAction $issueAuthTokenAction
    ) {}

    public function execute($data)
    {
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->issueAuthTokenAction->execute($user);
    }
}
