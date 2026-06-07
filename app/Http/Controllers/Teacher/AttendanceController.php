<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\ClassTeacher;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        
        if (!$teacher) {
            abort(403);
        }

        // Get classes where this teacher is class teacher
        $classTeachers = ClassTeacher::where('teacher_id', $teacher->id)
            ->with(['class', 'section'])
            ->get();

        return view('teacher.attendance.index', compact('classTeachers'));
    }

    public function create(Request $request)
    {
        $teacher = auth()->user()->teacher;
        $classId = $request->query('class_id');
        $sectionId = $request->query('section_id');
        $date = $request->query('date', today());

        // Verify teacher teaches this class
        ClassTeacher::where('teacher_id', $teacher->id)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->firstOrFail();

        $students = Student::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->with('user')
            ->get();

        $existingAttendance = Attendance::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->whereDate('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.take', compact(
            'classId',
            'sectionId',
            'students',
            'date',
            'existingAttendance'
        ));
    }

    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;
        
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        // Verify teacher teaches this class
        ClassTeacher::where('teacher_id', $teacher->id)
            ->where('class_id', $validated['class_id'])
            ->where('section_id', $validated['section_id'])
            ->firstOrFail();

        foreach ($validated['attendance'] as $item) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $item['student_id'],
                    'attendance_date' => $validated['attendance_date'],
                ],
                [
                    'school_id' => auth()->user()->school_id,
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'status' => $item['status'],
                    'remarks' => $item['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance recorded successfully');
    }
}
