<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::paginate(15);
        return view('super-admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('super-admin.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain_name' => 'required|string|unique:schools|max:255',
            'email' => 'required|email|unique:schools',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'principal_name' => 'required|string',
            'principal_email' => 'required|email',
            'principal_phone' => 'required|string',
            'subscription_plan' => 'required|in:basic,standard,premium',
            'subscription_start_date' => 'required|date',
            'subscription_end_date' => 'required|date|after:subscription_start_date',
        ]);

        $validated['slug'] = \Str::slug($validated['name']);

        School::create($validated);

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'School created successfully');
    }

    public function show(School $school)
    {
        $usersCount = $school->users()->count();
        $studentsCount = $school->students()->count();
        $teachersCount = $school->teachers()->count();

        return view('super-admin.schools.show', compact('school', 'usersCount', 'studentsCount', 'teachersCount'));
    }

    public function edit(School $school)
    {
        return view('super-admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email,' . $school->id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'principal_name' => 'required|string',
            'principal_email' => 'required|email',
            'principal_phone' => 'required|string',
            'subscription_plan' => 'required|in:basic,standard,premium',
            'subscription_start_date' => 'required|date',
            'subscription_end_date' => 'required|date|after:subscription_start_date',
            'is_active' => 'boolean',
        ]);

        $school->update($validated);

        return redirect()->route('super-admin.schools.index')
            ->with('success', 'School updated successfully');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return redirect()->route('super-admin.schools.index')
            ->with('success', 'School deleted successfully');
    }
}
