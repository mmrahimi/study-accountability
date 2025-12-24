<?php

namespace App\Actions\Streak;

class CreateStreakAction
{
    public function execute($user)
    {
        $user->streak()->create();
    }
}
