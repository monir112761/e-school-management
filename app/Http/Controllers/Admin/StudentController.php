<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $students = Student::where('school_id', $schoolId)
            ->with(['user', 'class', 'section'])
            ->paginate(20);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->get();

        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'admission_no' => 'required|string|unique:students',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'blood_group' => 'nullable|string',
            'nationality' => 'nullable|string',
            'religion' => 'nullable|string',
        ]);

        $schoolId = auth()->user()->school_id;

        // Create User
        $user = User::create([
            'school_id' => $schoolId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'student',
            'password' => bcrypt('password'),
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'address' => $validated['address'],
        ]);

        // Create Student
        Student::create([
            'school_id' => $schoolId,
            'user_id' => $user->id,
            'class_id' => $validated['class_id'],
            'section_id' => $validated['section_id'],
            'admission_no' => $validated['admission_no'],
            'admission_date' => now(),
            'blood_group' => $validated['blood_group'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'religion' => $validated['religion'] ?? null,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully');
    }

    public function edit(Student $student)
    {
        $schoolId = auth()->user()->school_id;
        if ($student->school_id !== $schoolId) {
            abort(403);
        }

        $classes = SchoolClass::where('school_id', $schoolId)->get();
        $sections = Section::where('class_id', $student->class_id)->get();

        return view('admin.students.edit', compact('student', 'classes', 'sections'));
    }

    public function update(Request $request, Student $student)
    {
        $schoolId = auth()->user()->school_id;
        if ($student->school_id !== $schoolId) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'phone' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'blood_group' => 'nullable|string',
            'nationality' => 'nullable|string',
            'religion' => 'nullable|string',
        ]);

        $student->user()->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        $student->update([
            'class_id' => $validated['class_id'],
            'section_id' => $validated['section_id'],
            'blood_group' => $validated['blood_group'],
            'nationality' => $validated['nationality'],
            'religion' => $validated['religion'],
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $schoolId = auth()->user()->school_id;
        if ($student->school_id !== $schoolId) {
            abort(403);
        }

        $student->user()->delete();
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully');
    }
}
