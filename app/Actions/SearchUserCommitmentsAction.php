<?php

namespace App\Actions;

use App\Models\Commitment;

class SearchUserCommitmentsAction
{
    public function execute($user, $term, $status)
    {
        return Commitment::search($term)
            ->where('user_id', $user->id)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->get();
    }
}
