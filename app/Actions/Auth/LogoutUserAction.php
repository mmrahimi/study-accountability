<?php

namespace App\Actions\Auth;

class LogoutUserAction
{
    public function execute($user)
    {
        $user->currentAccessToken()->delete();
    }
}
