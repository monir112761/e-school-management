<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\FeePayment;
use App\Models\ClassRoutine;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            abort(403, 'Not a student');
        }

        $results = Result::where('student_id', $student->id)->get();
        
        $attendancePresent = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
            
        $attendanceTotal = Attendance::where('student_id', $student->id)
            ->count();

        $feesPaid = FeePayment::where('student_id', $student->id)
            ->where('status', 'completed')
            ->sum('amount_paid');

        $classRoutines = ClassRoutine::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->with(['subject', 'teacher.user'])
            ->get()
            ->groupBy('day_of_week');

        return view('student.dashboard', [
            'student' => $student,
            'results' => $results,
            'attendancePresent' => $attendancePresent,
            'attendanceTotal' => $attendanceTotal,
            'attendancePercentage' => $attendanceTotal > 0 ? ($attendancePresent / $attendanceTotal) * 100 : 0,
            'feesPaid' => $feesPaid,
            'classRoutines' => $classRoutines,
        ]);
    }
}
