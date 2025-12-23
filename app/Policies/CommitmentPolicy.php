<?php

namespace App\Policies;

use App\Models\Commitment;
use App\Models\User;

class CommitmentPolicy
{
    public function view(User $user, Commitment $commitment)
    {
        return $commitment->user_id == $user->id;
    }

    public function update(User $user, Commitment $commitment)
    {
        return $commitment->user_id == $user->id;
    }

    public function cancel(User $user, Commitment $commitment)
    {
        return $commitment->user_id == $user->id;
    }
}
