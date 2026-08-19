<?php

namespace App\Services;

use App\Models\Fee;
use App\Models\StudentProfile;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;
class SubscriptionService
{
    public function __construct(protected SubscriptionRepository $subscriptionRepository)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Naya subscription checkout session banata hai. Agar student ka pehle se
     * Stripe Customer nahi hai, to pehle wo bhi bana deta hai.
     */
 

public function createSubscriptionCheckout(Fee $fee): Session
{
    $student = $fee->student;

    $subscription = $this->subscriptionRepository->findByFeeId($fee->id);

    if (!$subscription) {
        $subscription = $this->subscriptionRepository->create([
            'student_id' => $student->id,
            'fee_id' => $fee->id,
            'amount' => $fee->amount,
            'currency' => 'usd',

            'status' => 'incomplete',
        ]);
    }

    if (!$subscription->stripe_customer_id) {
        $customer = Customer::create([
            'email' => $student->user->email,
            'name' => $student->user->name,
            'metadata' => ['student_id' => $student->id],
        ]);

        $subscription = $this->subscriptionRepository->update($subscription, [
            'stripe_customer_id' => $customer->id,
        ]);
    }

    $session = Session::create([
        'customer' => $subscription->stripe_customer_id,
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Monthly Subscription - ' . $fee->semester,
                ],
                'unit_amount' => (int) ($subscription->amount * 100),
                'recurring' => ['interval' => 'month'],
            ],
            'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'subscription_data' => [
            'metadata' => ['subscription_id' => $subscription->id],
        ],
        'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('subscription.cancel'),
    ]);

    return $session;
}
    
    public function activate(string $stripeSubscriptionId, ?int $subscriptionId, ?string $periodEnd): void
    {
        $subscription = $subscriptionId
            ? Subscription::find($subscriptionId)
            : $this->subscriptionRepository->findByStripeSubscriptionId($stripeSubscriptionId);

        if (!$subscription) {
            return;
        }

        $this->subscriptionRepository->update($subscription, [
            'stripe_subscription_id' => $stripeSubscriptionId,
            'status' => 'active',
            'current_period_end' => $periodEnd ? \Carbon\Carbon::createFromTimestamp($periodEnd) : null,
        ]);
    }

   
public function markRenewalSucceeded(string $stripeSubscriptionId, ?string $periodEnd): void
{
    $subscription = $this->subscriptionRepository->findByStripeSubscriptionId($stripeSubscriptionId);

    if ($subscription) {
        $this->subscriptionRepository->update($subscription, [
            'status' => 'active',
            'current_period_end' => $periodEnd ? \Carbon\Carbon::createFromTimestamp($periodEnd) : null,
        ]);

        // Related Fee ko bhi "paid" mark karo is mahine ke liye
        if ($subscription->fee_id) {
            $subscription->fee->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }
}

    
    public function markRenewalFailed(string $stripeSubscriptionId): void
    {
        $subscription = $this->subscriptionRepository->findByStripeSubscriptionId($stripeSubscriptionId);

        if ($subscription) {
            $this->subscriptionRepository->update($subscription, [
                'status' => 'past_due',
            ]);
        }
    }

    public function listAll()
    {
        return $this->subscriptionRepository->getAll();
    }
}