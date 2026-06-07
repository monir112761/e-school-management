<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Student;
use App\Models\ClassTeacher;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;
        
        if (!$teacher) {
            abort(403);
        }

        // Get exams for subjects taught by this teacher
        $results = Result::whereHas('subject', function ($query) {
            return $query->whereIn('id', auth()->user()->teacher->classRoutines->pluck('subject_id'));
        })->with(['student.user', 'exam', 'subject'])
            ->paginate(20);

        return view('teacher.results.index', compact('results'));
    }

    public function create()
    {
        $teacher = auth()->user()->teacher;
        
        if (!$teacher) {
            abort(403);
        }

        // Get only subjects this teacher teaches
        $subjects = Subject::whereIn(
            'id',
            $teacher->classRoutines->pluck('subject_id')
        )->get();

        // Get students from classes this teacher teaches
        $classIds = ClassTeacher::where('teacher_id', $teacher->id)
            ->pluck('class_id');

        $students = Student::whereIn('class_id', $classIds)->with('user')->get();

        $exams = Exam::where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->get();

        return view('teacher.results.create', compact('subjects', 'students', 'exams'));
    }

    public function store(Request $request)
    {
        $teacher = auth()->user()->teacher;
        
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.marks_obtained' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($validated['results'] as $item) {
            $marks = $item['marks_obtained'];
            $percentage = $marks;
            $grade = $this->calculateGrade($marks);

            Result::updateOrCreate(
                [
                    'exam_id' => $validated['exam_id'],
                    'student_id' => $item['student_id'],
                    'subject_id' => $validated['subject_id'],
                ],
                [
                    'marks_obtained' => $marks,
                    'percentage' => $percentage,
                    'grade' => $grade,
                ]
            );
        }

        return redirect()->route('teacher.results.index')
            ->with('success', 'Results recorded successfully');
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F';
    }
}
