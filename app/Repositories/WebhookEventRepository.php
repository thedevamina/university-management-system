<?php

namespace App\Repositories;

use App\Models\WebhookEvent;

class WebhookEventRepository
{
    public function alreadyProcessed(string $stripeEventId): bool
    {
        return WebhookEvent::where('stripe_event_id', $stripeEventId)->exists();
    }

  public function log(
    string $stripeEventId,
    string $type,
    array $payload,
    ?string $stripeSessionId = null,
    ?string $stripePaymentIntentId = null,
    ?string $stripeSubscriptionId = null,
    ?string $stripeInvoiceId = null,
    bool $processed = false,
    ?string $error = null
): WebhookEvent {

    \Log::info('Repository Received', [
        'stripe_session_id' => $stripeSessionId,
        'stripe_payment_intent_id' => $stripePaymentIntentId,
        'stripe_subscription_id' => $stripeSubscriptionId,
        'stripe_invoice_id' => $stripeInvoiceId,
    ]);

    $event = new WebhookEvent();

    $event->stripe_event_id = $stripeEventId;
    $event->stripe_session_id = $stripeSessionId;
    $event->stripe_payment_intent_id = $stripePaymentIntentId;
    $event->stripe_subscription_id = $stripeSubscriptionId;
    $event->stripe_invoice_id = $stripeInvoiceId;

    $event->type = $type;
    $event->payload = $payload;
    $event->processed = $processed;
    $event->error_message = $error;

    $event->save();

    \Log::info('Saved Webhook', $event->toArray());

    return $event;
}

    public function markProcessed(WebhookEvent $event): void
    {
        $event->update([
            'processed' => true,
        ]);
    }

    public function markFailed(WebhookEvent $event, string $error): void
    {
        $event->update([
            'processed' => false,
            'error_message' => $error,
        ]);
    }

   public function getAll()
{
    return WebhookEvent::with([
        'payment',
        'subscription',
    ])
    ->latest()
    ->paginate(20);
}

    public function forIdentifiers(
        array $sessionIds,
        array $paymentIntentIds,
        array $subscriptionIds = []
    ) {
        if (
            empty($sessionIds) &&
            empty($paymentIntentIds) &&
            empty($subscriptionIds)
        ) {
            return collect();
        }

        return WebhookEvent::where(function ($query) use (
            $sessionIds,
            $paymentIntentIds,
            $subscriptionIds
        ) {

            foreach ($sessionIds as $sessionId) {
                if ($sessionId) {
                    $query->orWhere(
                        'payload',
                        'like',
                        '%' . $sessionId . '%'
                    );
                }
            }

            foreach ($paymentIntentIds as $intentId) {
                if ($intentId) {
                    $query->orWhere(
                        'payload',
                        'like',
                        '%' . $intentId . '%'
                    );
                }
            }

            foreach ($subscriptionIds as $subscriptionId) {
                if ($subscriptionId) {
                    $query->orWhere(
                        'payload',
                        'like',
                        '%' . $subscriptionId . '%'
                    );
                }
            }
        })
        ->latest()
        ->get();
    }
}