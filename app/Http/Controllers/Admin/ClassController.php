<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)
            ->with('sections')
            ->paginate(15);

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|string|max:10|unique:classes,numeric_value,NULL,id,school_id,' . auth()->user()->school_id,
            'description' => 'nullable|string',
        ]);

        $validated['school_id'] = auth()->user()->school_id;

        SchoolClass::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class created successfully');
    }

    public function edit(SchoolClass $class)
    {
        if ($class->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        if ($class->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class updated successfully');
    }

    public function destroy(SchoolClass $class)
    {
        if ($class->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Class deleted successfully');
    }
}
