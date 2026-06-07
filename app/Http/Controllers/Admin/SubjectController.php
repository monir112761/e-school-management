<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $subjects = Subject::where('school_id', $schoolId)
            ->with('class')
            ->paginate(20);

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->get();

        return view('admin.subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects',
            'description' => 'nullable|string',
        ]);

        $validated['school_id'] = auth()->user()->school_id;

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully');
    }

    public function edit(Subject $subject)
    {
        if ($subject->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->get();

        return view('admin.subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        if ($subject->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully');
    }
}
