<?php

namespace App\Actions\Streak;

class UpdateStreakAction
{
    public function execute($user, $status)
    {
        if ($status == 'missed') {
            $user->streak->update([
                'current' => 0,
            ]);
        }

        if ($status == 'checked') {
            $streak = $user->streak;

            $streak->current += 1;
            $streak->longest = max($streak->longest, $streak->current);

            $streak->save();
        }
    }
}
