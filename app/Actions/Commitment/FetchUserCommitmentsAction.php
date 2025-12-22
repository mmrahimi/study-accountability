<?php

namespace App\Actions\Commitment;

class FetchUserCommitmentsAction
{
    public function execute($user, $status)
    {
        return $user->commitments()
            ->where('status', $status)
            ->orderBy('commitment_date')
            ->get();
    }
}
