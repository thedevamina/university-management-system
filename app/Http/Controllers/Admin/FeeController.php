<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\StudentProfile;
use App\Services\FeeService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function __construct(protected FeeService $feeService)
    {
    }

    public function index()
    {
        $fees = $this->feeService->listFees();
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

        $this->feeService->createFee($validated);

        return redirect()->route('admin.fees.index')->with('success', 'Fee record created.');
    }

    public function markPaid(Fee $fee)
    {
        $this->feeService->markPaid($fee);
        return back()->with('success', 'Fee marked as paid.');
    }

    public function destroy(Fee $fee)
    {
        $this->feeService->deleteFee($fee);
        return back()->with('success', 'Fee record removed.');
    }

    public function myFees()
    {
        $student = auth()->user()->studentProfile;
        $fees = $this->feeService->myFees($student->id);

        return view('student.fees.index', compact('fees'));
    }
}