<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdmitCard;

class AdmitCardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        
        if (!$student) {
            abort(403);
        }

        $admitCards = AdmitCard::where('student_id', $student->id)
            ->with('exam')
            ->latest()
            ->paginate(10);

        return view('student.admit-cards.index', compact('admitCards'));
    }

    public function download(AdmitCard $admitCard)
    {
        $student = auth()->user()->student;
        
        if (!$student || $admitCard->student_id !== $student->id) {
            abort(403);
        }

        // Update status to downloaded
        $admitCard->update(['status' => 'downloaded']);

        if ($admitCard->document_path && file_exists(storage_path('app/' . $admitCard->document_path))) {
            return response()->download(storage_path('app/' . $admitCard->document_path));
        }

        return back()->with('error', 'Document not found');
    }
}
