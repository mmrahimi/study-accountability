<?php

namespace App\Actions\Streak;

class CreateUserStreakAction
{
    public function execute($user)
    {
        $user->streak()->create();
    }
}
