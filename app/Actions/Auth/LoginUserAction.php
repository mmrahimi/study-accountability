<?php

namespace App\Actions\Auth;

use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function __construct(
        private IssueAuthTokenAction $issueAuthTokenAction
    ) {}

    public function execute($data)
    {
        $user = $this->findUser($data['username']);

        $this->ensurePasswordIsValid($data['password'], $user);

        return $this->issueAuthTokenAction->execute($user);
    }

    private function findUser($username)
    {
        return User::where('username', $username)->firstOrFail();
    }

    private function ensurePasswordIsValid($password, $user)
    {
        if (! Hash::check($password, $user->password)) {
            throw new DomainException('Invalid credentials');
        }
    }
}
