<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Result;
use App\Models\ClassTeacher;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        
        if (!$teacher) {
            abort(403, 'Not a teacher');
        }

        // Get classes taught by this teacher
        $classTeachers = ClassTeacher::where('teacher_id', $teacher->id)
            ->with(['class', 'section'])
            ->get();

        $studentsCount = Student::whereIn(
            'class_id',
            $classTeachers->pluck('class_id')
        )->count();

        return view('teacher.dashboard', [
            'teacher' => $teacher,
            'classTeachers' => $classTeachers,
            'studentsCount' => $studentsCount,
        ]);
    }
}
