<?php

namespace App\Http\Controllers;

use App\Actions\Subject\FetchAllSubjectsAction;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(FetchAllSubjectsAction $action)
    {
        return response()->json([
            'subjects' => $action->execute(),
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Subject $subject)
    {
        return response()->json([
            'subject' => $subject,
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
