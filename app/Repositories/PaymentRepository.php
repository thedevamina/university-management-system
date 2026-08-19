<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function findById(int $id): ?Payment
    {
        return Payment::find($id);
    }

    public function findBySessionId(string $sessionId): ?Payment
    {
        return Payment::where('stripe_session_id', $sessionId)->first();
    }

    public function findByPaymentIntentId(string $paymentIntentId): ?Payment
    {
        return Payment::where('stripe_payment_id', $paymentIntentId)->first();
    }

    public function markPaidWithIntent(Payment $payment, ?string $paymentIntentId): Payment
    {
        $payment->update([
            'status' => 'paid',
            'stripe_payment_id' => $paymentIntentId,
        ]);
        return $payment;
    }

    public function markFailed(Payment $payment): Payment
    {
        $payment->update(['status' => 'failed']);
        return $payment;
    }

    public function markExpired(Payment $payment): Payment
    {
        $payment->update(['status' => 'expired']);
        return $payment;
    }
}