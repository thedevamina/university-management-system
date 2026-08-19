<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\WebhookEvent;
use App\Repositories\WebhookEventRepository;
use App\Models\Payment;
use App\Models\Subscription;
class WebhookEventController extends Controller
{
    public function __construct(
        protected WebhookEventRepository $webhookEventRepository
    ) {
    }

    /**
     * Show all webhook events.
     */
    public function index()
    {
        $events = $this->webhookEventRepository->getAll();

        return view(
            'admin.webhook-events.index',
            compact('events')
        );
    }

    /**
     * Show webhook events related to a specific fee.
     */
   public function forFee(Fee $fee)
{
    $payment = $fee->payments()->latest()->first();

    $subscription = $fee->subscription;

    return view(
        'admin.webhook-events.for-fee',
        compact(
            'fee',
            'payment',
            'subscription'
        )
    );
}
     
public function showPayment(Payment $payment)
{
    $events = $payment->webhookEvents()
        ->latest()
        ->get();

    return view(
        'admin.webhook-events.payment-timeline',
        compact(
            'payment',
            'events'
        )
    );
}

public function showSubscription(Subscription $subscription)
{
    $events = $subscription->webhookEvents()
        ->latest()
        ->get();

    return view(
        'admin.webhook-events.subscription-timeline',
        compact(
            'subscription',
            'events'
        )
    );
}
    /**
     * Show a single webhook event.
     */
    public function show(WebhookEvent $webhookEvent)
    {
        $payload = $webhookEvent->payload;
        $object = $payload['data']['object'] ?? [];

        $relatedEvents = collect();

        if (($object['object'] ?? null) === 'checkout.session') {

            $paymentIntent = $object['payment_intent'] ?? null;

            if ($paymentIntent) {
                $relatedEvents = WebhookEvent::where(
                    'payload',
                    'like',
                    '%' . $paymentIntent . '%'
                )
                ->latest()
                ->get();
            }
        }

        if (($object['object'] ?? null) === 'payment_intent') {

            $paymentIntent = $object['id'];

            $relatedEvents = WebhookEvent::where(
                'payload',
                'like',
                '%' . $paymentIntent . '%'
            )
            ->latest()
            ->get();
        }

        if (($object['object'] ?? null) === 'subscription') {

            $subscriptionId = $object['id'];

            $relatedEvents = WebhookEvent::where(
                'payload',
                'like',
                '%' . $subscriptionId . '%'
            )
            ->latest()
            ->get();
        }

        if (($object['object'] ?? null) === 'invoice') {

            $subscriptionId =
                $object['parent']['subscription_details']['subscription']
                ?? $object['subscription']
                ?? null;

            if ($subscriptionId) {
                $relatedEvents = WebhookEvent::where(
                    'payload',
                    'like',
                    '%' . $subscriptionId . '%'
                )
                ->latest()
                ->get();
            }
        }

        return view(
            'admin.webhook-events.show',
            compact(
                'webhookEvent',
                'relatedEvents'
            )
        );
    }
}