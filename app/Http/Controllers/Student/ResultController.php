<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\AdmitCard;
use App\Models\FeePayment;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            abort(403);
        }

        $results = Result::where('student_id', $student->id)
            ->with(['exam', 'subject'])
            ->latest()
            ->paginate(15);

        return view('student.results.index', compact('results'));
    }

    public function show(Result $result)
    {
        $student = auth()->user()->student;
        
        if (!$student || $result->student_id !== $student->id) {
            abort(403);
        }

        return view('student.results.show', compact('result'));
    }
}
