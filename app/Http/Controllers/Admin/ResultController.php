<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $results = Result::whereHas('student', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->with(['student.user', 'exam', 'subject'])->paginate(20);

        return view('admin.results.index', compact('results'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $exams = Exam::where('school_id', $schoolId)->get();
        $students = Student::where('school_id', $schoolId)->with('user')->get();

        return view('admin.results.create', compact('exams', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'results' => 'required|array',
            'results.*.subject_id' => 'required|exists:subjects,id',
            'results.*.marks_obtained' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($validated['results'] as $item) {
            $marks = $item['marks_obtained'];
            $percentage = $marks;
            $grade = $this->calculateGrade($marks);

            Result::updateOrCreate(
                [
                    'exam_id' => $validated['exam_id'],
                    'student_id' => $validated['student_id'],
                    'subject_id' => $item['subject_id'],
                ],
                [
                    'marks_obtained' => $marks,
                    'percentage' => $percentage,
                    'grade' => $grade,
                ]
            );
        }

        return redirect()->route('admin.results.index')
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
