<?php

namespace App\Actions\Subject;

class StoreSubjectAction
{
    public function execute($user, $data)
    {
        return $user->subjects()
            ->create($data);
    }
}
