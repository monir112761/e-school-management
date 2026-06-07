<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $fees = Fee::where('school_id', $schoolId)
            ->with('class')
            ->paginate(15);

        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->get();

        return view('admin.fees.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'fee_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_day_of_month' => 'nullable|integer|min:1|max:31',
            'due_date' => 'nullable|date',
        ]);

        $validated['school_id'] = auth()->user()->school_id;

        Fee::create($validated);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee created successfully');
    }

    public function edit(Fee $fee)
    {
        if ($fee->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $schoolId = auth()->user()->school_id;
        $classes = SchoolClass::where('school_id', $schoolId)->get();

        return view('admin.fees.edit', compact('fee', 'classes'));
    }

    public function update(Request $request, Fee $fee)
    {
        if ($fee->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'fee_type' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_day_of_month' => 'nullable|integer|min:1|max:31',
            'due_date' => 'nullable|date',
        ]);

        $fee->update($validated);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee updated successfully');
    }

    public function destroy(Fee $fee)
    {
        if ($fee->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $fee->delete();

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee deleted successfully');
    }

    public function payments()
    {
        $schoolId = auth()->user()->school_id;
        $payments = FeePayment::whereHas('student', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->with(['student.user', 'fee'])->paginate(20);

        return view('admin.fees.payments', compact('payments'));
    }
}
