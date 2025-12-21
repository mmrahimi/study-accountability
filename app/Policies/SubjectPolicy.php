<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    public function view(User $user, Subject $subject)
    {
        return $subject->user_id == $user->id;
    }

    public function update(User $user, Subject $subject)
    {
        return $subject->user_id == $user->id;
    }

    public function delete(User $user, Subject $subject)
    {
        return $subject->user_id == $user->id;
    }
}
