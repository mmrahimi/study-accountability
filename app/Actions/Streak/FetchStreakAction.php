<?php

namespace App\Actions\Streak;

class FetchStreakAction
{
    public function execute($user)
    {
        return $user->streak;
    }
}
