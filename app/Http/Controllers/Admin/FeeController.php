<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\StudentProfile;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('student.user')->latest()->paginate(15);
        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        $students = StudentProfile::with('user')->get();
        return view('admin.fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student_profiles,id',
            'semester' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        Fee::create($validated);

        return redirect()->route('admin.fees.index')->with('success', 'Fee record created.');
    }

    public function markPaid(Fee $fee)
    {
        $fee->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Fee marked as paid.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();
        return back()->with('success', 'Fee record removed.');
    }

    public function myFees()
{
    $student = auth()->user()->studentProfile;

    $fees = Fee::where('student_id', $student->id)->latest()->get();

    return view('student.fees.index', compact('fees'));
}
}