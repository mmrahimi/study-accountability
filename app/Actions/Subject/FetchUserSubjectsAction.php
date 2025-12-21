<?php

namespace App\Actions\Subject;

use App\Models\Subject;

class FetchUserSubjectsAction
{
    public function execute($user)
    {
        return Subject::where('user_id', $user->id)
            ->get();
    }
}
