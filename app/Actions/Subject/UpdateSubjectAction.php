<?php

namespace App\Actions\Subject;

class UpdateSubjectAction
{
    public function execute($subject, $data)
    {
        $subject->update($data);
    }
}
