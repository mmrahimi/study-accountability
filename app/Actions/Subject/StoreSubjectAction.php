<?php

namespace App\Actions\Subject;

class StoreSubjectAction
{
    public function execute($user, $data)
    {
        $user->subjects()
            ->create($data);
    }
}
