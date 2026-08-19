<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    public function findByFeeId(int $feeId): ?Subscription
{
    return Subscription::where('fee_id', $feeId)->first();
}

    public function findByStripeSubscriptionId(string $stripeSubscriptionId): ?Subscription
    {
        return Subscription::where('stripe_subscription_id', $stripeSubscriptionId)->first();
    }

    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }

    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update($data);
        return $subscription;
    }

    public function getAll()
    {
        return Subscription::with('student.user')->latest()->paginate(20);
    }
}