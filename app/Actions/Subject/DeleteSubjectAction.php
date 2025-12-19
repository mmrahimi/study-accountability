<?php

namespace App\Actions\Subject;

class DeleteSubjectAction
{
    public function execute($subject)
    {
        $subject->delete();
    }
}
