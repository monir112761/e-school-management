<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Attendance;
use App\Models\FeePayment;

class DashboardController extends Controller
{
    public function index()
    {
        $guardian = auth()->user()->guardian;
        
        if (!$guardian) {
            abort(403, 'Not a guardian');
        }

        $students = $guardian->students()->with(['class', 'section'])->get();

        $childrenData = [];
        foreach ($students as $student) {
            $results = Result::where('student_id', $student->id)->latest()->take(5)->get();
            
            $attendance = Attendance::where('student_id', $student->id)->count();
            $presentDays = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->count();

            $pendingFees = FeePayment::where('student_id', $student->id)
                ->where('status', 'pending')
                ->sum('amount_paid');

            $childrenData[] = [
                'student' => $student,
                'results' => $results,
                'attendancePercentage' => $attendance > 0 ? ($presentDays / $attendance) * 100 : 0,
                'pendingFees' => $pendingFees,
            ];
        }

        return view('guardian.dashboard', [
            'guardian' => $guardian,
            'students' => $students,
            'childrenData' => $childrenData,
        ]);
    }
}
