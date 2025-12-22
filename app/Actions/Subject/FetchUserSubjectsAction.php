<?php

namespace App\Actions\Subject;

class FetchUserSubjectsAction
{
    public function execute($user)
    {
        return $user->subjects;
    }
}
