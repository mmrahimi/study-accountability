<?php

namespace App\Actions\Subject;

use App\Models\Subject;

class FetchAllSubjectsAction
{
    public function execute()
    {
        return Subject::all();
    }
}
