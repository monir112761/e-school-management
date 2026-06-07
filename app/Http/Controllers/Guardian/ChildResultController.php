<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\FeePayment;

class ChildResultController extends Controller
{
    public function index($childId = null)
    {
        $guardian = auth()->user()->guardian;
        
        if (!$guardian) {
            abort(403);
        }

        $students = $guardian->students()->get();

        if (!$childId && $students->count() > 0) {
            $childId = $students->first()->id;
        }

        if ($childId) {
            $student = $students->where('id', $childId)->first();
            
            if (!$student) {
                abort(403);
            }

            $results = Result::where('student_id', $student->id)
                ->with(['exam', 'subject'])
                ->latest()
                ->get();
        } else {
            $results = [];
        }

        return view('guardian.results.index', compact('students', 'childId', 'results'));
    }
}
