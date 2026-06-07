<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FeePayment;

class FeeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            abort(403);
        }

        $payments = FeePayment::where('student_id', $student->id)
            ->with('fee')
            ->latest()
            ->paginate(15);

        $totalAmount = $payments->sum('amount_paid');
        $pendingAmount = FeePayment::where('student_id', $student->id)
            ->where('status', 'pending')
            ->sum('amount_paid');

        return view('student.fees.index', compact('payments', 'totalAmount', 'pendingAmount'));
    }
}
