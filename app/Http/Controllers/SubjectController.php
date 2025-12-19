<?php

namespace App\Http\Controllers;

use App\Actions\Subject\FetchAllSubjectsAction;
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

    public function show($id)
    {
        //
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
