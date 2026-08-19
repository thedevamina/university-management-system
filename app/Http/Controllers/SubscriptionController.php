<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\Request;
 use App\Models\Fee;
class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
    }

    // Student "Subscribe" pe click karta hai


public function checkout(Fee $fee)
{
    abort_if($fee->student_id !== auth()->user()->studentProfile->id, 403);

    $session = $this->subscriptionService->createSubscriptionCheckout($fee);

    return redirect($session->url);
}

    // Stripe se wapas aata hai (success)
    public function success()
    {
        return redirect()
            ->route('student.subscription')
            ->with('success', 'Subscription started successfully! First payment will be charged now, then every month automatically.');
    }

    public function cancel()
    {
        return redirect()
            ->route('student.subscription')
            ->with('error', 'Subscription setup was cancelled.');
    }

    // Student apni subscription dekhta hai
    public function show()
    {
        $student = auth()->user()->studentProfile;
        $subscription = $student->subscription;

        return view('student.subscription.index', compact('subscription'));
    }
}