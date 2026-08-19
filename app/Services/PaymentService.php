<?php

namespace App\Services;

use App\Models\Fee;
use App\Repositories\PaymentRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentService
{
    public function __construct(protected PaymentRepository $paymentRepository)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession(Fee $fee): Session
    {
        $payment = $this->paymentRepository->create([
            'fee_id' => $fee->id,
            'student_id' => $fee->student_id,
            'stripe_session_id' => null,
            'amount' => $fee->amount,
            'currency' => 'usd',
            'status' => 'pending',
        ]);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'University Fee - ' . $fee->semester,
                    ],
                    'unit_amount' => (int) ($fee->amount * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'payment_intent_data' => [
                'metadata' => [
                    'payment_id' => $payment->id,
                ],
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        $payment->update(['stripe_session_id' => $session->id]);

        return $session;
    }

public function confirmPaymentIntent(string $paymentIntentId, ?int $paymentId = null): void
{
    $payment = $paymentId
        ? $this->paymentRepository->findById($paymentId)
        : $this->paymentRepository->findByPaymentIntentId($paymentIntentId);

    if (!$payment) {
        return;
    }

    if ($payment->status === 'paid') {
        return;
    }

    $this->paymentRepository->markPaidWithIntent(
        $payment,
        $paymentIntentId
    );

    $payment->fee->update([
        'status' => 'paid',
        'paid_at' => now(),
    ]);
}

    public function handleProcessingPayment(string $paymentIntentId): void
{
    $payment = $this->paymentRepository->findByPaymentIntentId($paymentIntentId);

    if ($payment && $payment->status === 'pending') {
        $payment->update([
            'stripe_payment_id' => $paymentIntentId,
            'status' => 'processing',
        ]);
    }
}

    public function handleFailedPayment(string $paymentIntentId, ?int $paymentId = null): void
    {
        $payment = $paymentId ? $this->paymentRepository->findById($paymentId) : null;

        if ($payment && $payment->status === 'pending') {
            $this->paymentRepository->markFailed($payment);
            $payment->update(['stripe_payment_id' => $paymentIntentId]);
        }
    }

    public function handleExpiredSession(string $sessionId): void
    {
        $payment = $this->paymentRepository->findBySessionId($sessionId);

        if ($payment && $payment->status === 'pending') {
            $this->paymentRepository->markExpired($payment);
        }
    }
}