<?php

namespace App\Actions\Auth;

use Laravel\Sanctum\PersonalAccessToken;

class IssueAuthTokenAction
{
    public function execute($user)
    {
        $token = $user->createToken('api-token')->plainTextToken;
        $accessToken = PersonalAccessToken::findToken($token);

        $accessToken->expires_at = now()->addHours(8);
        $accessToken->save();

        return $token;
    }
}
