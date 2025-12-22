<?php

namespace App\Actions\Subject;

use App\Models\Subject;

class FetchUserSubjectsAction
{
    public function execute($user)
    {
        return $user->subjects;
    }
}
