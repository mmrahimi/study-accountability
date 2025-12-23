<?php

namespace App\Actions\Commitment;

class CancelCommitmentAction
{
    public function execute($commitment)
    {
        $commitment->update(['status' => 'canceled']);
    }
}
