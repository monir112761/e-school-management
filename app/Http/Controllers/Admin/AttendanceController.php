<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->get();

        return view('admin.attendance.index', compact('classes'));
    }

    public function create(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $classId = $request->query('class_id');
        $sectionId = $request->query('section_id');
        $date = $request->query('date', today());

        $class = SchoolClass::where('school_id', $schoolId)
            ->findOrFail($classId);
        $section = Section::findOrFail($sectionId);

        $students = Student::where('school_id', $schoolId)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->with('user')
            ->get();

        $existingAttendance = Attendance::where('school_id', $schoolId)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->whereDate('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        return view('admin.attendance.create', compact(
            'class',
            'section',
            'students',
            'date',
            'existingAttendance'
        ));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,leave,late',
            'attendance.*.remarks' => 'nullable|string',
        ]);

        foreach ($validated['attendance'] as $item) {
            Attendance::updateOrCreate(
                [
                    'school_id' => $schoolId,
                    'student_id' => $item['student_id'],
                    'attendance_date' => $validated['attendance_date'],
                ],
                [
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'status' => $item['status'],
                    'remarks' => $item['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance recorded successfully');
    }
}
