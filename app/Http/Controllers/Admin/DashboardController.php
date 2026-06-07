<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\FeePayment;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        
        $totalStudents = Student::where('school_id', $schoolId)->count();
        $totalTeachers = \App\Models\Teacher::where('school_id', $schoolId)->count();
        
        $presentToday = Attendance::where('school_id', $schoolId)
            ->whereDate('attendance_date', today())
            ->where('status', 'present')
            ->count();
            
        $totalFeeCollected = FeePayment::where('status', 'completed')
            ->whereDate('payment_date', '>=', now()->startOfMonth())
            ->sum('amount_paid');

        $upcomingExams = Exam::where('school_id', $schoolId)
            ->where('start_date', '>=', today())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'presentToday' => $presentToday,
            'totalFeeCollected' => $totalFeeCollected,
            'upcomingExams' => $upcomingExams,
        ]);
    }
}
