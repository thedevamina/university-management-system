<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function checkout(Fee $fee)
    {
        // Security: student sirf apni khud ki fee pay kar sake
        abort_if($fee->student_id !== auth()->user()->studentProfile->id, 403);
        abort_if($fee->status === 'paid', 400, 'This fee is already paid.');

        $session = $this->paymentService->createCheckoutSession($fee);

        return redirect($session->url);
    }

    
    // public function success(Request $request)
    // {
    //     $sessionId = $request->query('session_id');

    //     if ($sessionId) {
    //         $this->paymentService->confirmPayment($sessionId);
    //     }

    //     return redirect()->route('student.fees')->with('success', 'Payment successful! Your fee has been marked as paid.');
    // }

    public function success()
{
    return redirect()
        ->route('student.fees')
        ->with('success', 'Payment completed successfully.');
}

    
    public function cancel()
    {
        return redirect()->route('student.fees')->with('error', 'Payment was cancelled.');
    }
}