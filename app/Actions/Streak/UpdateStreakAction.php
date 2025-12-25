<?php

namespace App\Actions\Streak;

use App\Models\Commitment;

class UpdateStreakAction
{
    public function execute($user, $status)
    {
        if ($status == Commitment::STATUS_MISSED) {
            $user->streak->update([
                'current' => 0,
            ]);
        }

        if ($status == Commitment::STATUS_CHECKED) {
            $streak = $user->streak;

            $streak->current += 1;
            $streak->longest = max($streak->longest, $streak->current);

            $streak->save();
        }
    }
}
