<?php

namespace App\Actions\Subject;

class UpdateSubjectAction
{
    public function execute($subject, $data)
    {
        return $subject->update($data);
    }
}
