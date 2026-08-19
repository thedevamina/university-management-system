<?php

namespace App\Services;

use App\Repositories\WebhookEventRepository;
use Stripe\Event;
use App\Models\Payment;
use App\Models\Subscription;

use App\Services\SubscriptionService;
class WebhookService

{
   public function __construct(
    protected WebhookEventRepository $webhookEventRepository,
    protected PaymentService $paymentService,
    protected SubscriptionService $subscriptionService
) {
}

  public function process(Event $event): void
{
    \Log::info('Stripe EVENT RECEIVED', [
        'event_id' => $event->id,
        'type' => $event->type,
    ]);

    if ($this->webhookEventRepository->alreadyProcessed($event->id)) {
        return;
    }


        $models = $this->resolvePaymentAndSubscription($event);
        \Log::info('Resolved Models', [
    'event_type' => $event->type,
    'payment_id' => $models['payment']?->id,
    'subscription_id' => $models['subscription']?->id,
]);

$object = $event->data->object;

// ✅ NAYA CODE - yeh lagao
$stripeSessionId        = null;
$stripePaymentIntentId  = null;
$stripeSubscriptionId   = null;
$stripeInvoiceId        = null;

$objectType = $object->object ?? null;
\Log::info('Object Type Debug', [
    'objectType' => $objectType,
    'object_id'  => $object->id ?? null,
]);
if ($objectType === 'checkout.session') {
    $stripeSessionId       = $object->id ?? null;
    $stripePaymentIntentId = $object->payment_intent ?? null;
    $stripeSubscriptionId  = $object->subscription ?? null;
}

if ($objectType === 'payment_intent') {
    $stripePaymentIntentId = $object->id ?? null;
    $stripeSubscriptionId  = $object->subscription ?? null;
    $stripeInvoiceId       = $object->invoice ?? null;
}

if ($objectType === 'subscription') {
    $stripeSubscriptionId = $object->id ?? null;
}

if ($objectType === 'invoice') {
    $stripeInvoiceId = $object->id ?? null;
    $stripePaymentIntentId = $object->payment_intent ?? null;

    // Safe tarike se nested value nikalo
    $stripeSubscriptionId =
        $object->subscription
        ?? $object->parent?->subscription_details?->subscription
        ?? null;
}

$webhookEvent = $this->webhookEventRepository->log(
    stripeEventId:          $event->id,
    type:                   $event->type,
    payload:                $event->toArray(),
    stripeSessionId:        $stripeSessionId,
    stripePaymentIntentId:  $stripePaymentIntentId,
    stripeSubscriptionId:   $stripeSubscriptionId,
    stripeInvoiceId:        $stripeInvoiceId,
);

try{match ($event->type) {

    // One-time payment
    'checkout.session.completed' => $this->handleCheckoutCompleted($event),
    'checkout.session.expired' => $this->handleCheckoutExpired($event),
    'payment_intent.processing' => $this->handlePaymentProcessing($event),
    'payment_intent.succeeded' => $this->handlePaymentSucceeded($event),
    'payment_intent.payment_failed' => $this->handlePaymentFailed($event),

    // Subscription
    'customer.subscription.created' => $this->handleSubscriptionCreated($event),
    'customer.subscription.updated' => $this->handleSubscriptionUpdated($event),
    'customer.subscription.deleted' => $this->handleSubscriptionDeleted($event),

    // Invoice
    'invoice.payment_succeeded' => $this->handleInvoicePaymentSucceeded($event),
    'invoice.payment_failed' => $this->handleInvoicePaymentFailed($event),

    default => null,
};
            $this->webhookEventRepository->markProcessed($webhookEvent);

        } catch (\Throwable $e) {
            $this->webhookEventRepository->markFailed($webhookEvent, $e->getMessage());
            throw $e;
        }
    }
private function resolvePaymentAndSubscription(Event $event): array
{
    $object = $event->data->object;

    $payment = null;
    $subscription = null;

    /*
    |--------------------------------------------------------------------------
    | Checkout Session
    |--------------------------------------------------------------------------
    */

    if (($object->object ?? null) === 'checkout.session') {

        if (!empty($object->id)) {
            $payment = Payment::where(
                'stripe_session_id',
                $object->id
            )->first();
        }

        if (!empty($object->subscription)) {
            $subscription = Subscription::where(
                'stripe_subscription_id',
                $object->subscription
            )->first();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Intent
    |--------------------------------------------------------------------------
    */

   if (($object->object ?? null) === 'payment_intent') {

    if (!empty($object->metadata->payment_id)) {

        $payment = Payment::find(
            $object->metadata->payment_id
        );

    } else {

        $payment = Payment::where(
            'stripe_payment_id',
            $object->id
        )->first();

    }
}

    /*
    |--------------------------------------------------------------------------
    | Subscription
    |--------------------------------------------------------------------------
    */

    if (($object->object ?? null) === 'subscription') {

    if (!empty($object->metadata->subscription_id)) {

        $subscription = Subscription::find(
            $object->metadata->subscription_id
        );

    } else {

        $subscription = Subscription::where(
            'stripe_subscription_id',
            $object->id
        )->first();

    }
}
    /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    */

    if (($object->object ?? null) === 'invoice') {

        $stripeSubscriptionId =
            $object->parent->subscription_details->subscription
            ?? $object->subscription
            ?? null;

        if ($stripeSubscriptionId) {

            $subscription = Subscription::where(
                'stripe_subscription_id',
                $stripeSubscriptionId
            )->first();
        }
    }

    return [
        'payment' => $payment,
        'subscription' => $subscription,
    ];
}
    protected function handleCheckoutCompleted(Event $event): void
    {
        //$session = $event->data->object;
       // $paymentIntentId = $session->payment_intent ?? null;

        //$this->paymentService->confirmPaymentByIntent($session->id, $paymentIntentId);
    }

   protected function handlePaymentFailed(Event $event): void
{
    $paymentIntent = $event->data->object;

    $paymentId = $paymentIntent->metadata->payment_id ?? null;

    $this->paymentService->handleFailedPayment(
        $paymentIntent->id,
        $paymentId ? (int) $paymentId : null
    );
}

    protected function handleCheckoutExpired(Event $event): void
    {
        $session = $event->data->object;

        $this->paymentService->handleExpiredSession($session->id);
    }
    protected function handlePaymentProcessing(Event $event): void
{
    $paymentIntent = $event->data->object;

    $this->paymentService->handleProcessingPayment(
        $paymentIntent->id
    );
}

protected function handlePaymentSucceeded(Event $event): void
{
    $paymentIntent = $event->data->object;

    $paymentId = $paymentIntent->metadata->payment_id ?? null;

    $this->paymentService->confirmPaymentIntent(
        $paymentIntent->id,
        $paymentId ? (int) $paymentId : null
    );
}

protected function handleSubscriptionCreated(Event $event): void
{
    $subscription = $event->data->object;

    $subscriptionId = $subscription->metadata->subscription_id ?? null;
    $periodEnd = $subscription->current_period_end ?? null;

    $this->subscriptionService->activate(
        $subscription->id,
        $subscriptionId ? (int) $subscriptionId : null,
        $periodEnd
    );
}

protected function handleInvoicePaymentSucceeded(Event $event): void
{
    $invoice = $event->data->object;

    $stripeSubscriptionId =
        $invoice->parent->subscription_details->subscription
        ?? $invoice->subscription
        ?? null;

    $periodEnd = $invoice->lines->data[0]->period->end ?? null;

    $stripeInvoiceId = $invoice->id;

    if ($stripeSubscriptionId) {

        $this->subscriptionService->markRenewalSucceeded(
            $stripeSubscriptionId,
            $periodEnd,
            $stripeInvoiceId
        );
    }
}

protected function handleInvoicePaymentFailed(Event $event): void
{
    $invoice = $event->data->object;

    $stripeSubscriptionId = $invoice->parent->subscription_details->subscription ?? null;

    if ($stripeSubscriptionId) {
        $this->subscriptionService->markRenewalFailed($stripeSubscriptionId);
    }
}

protected function handleSubscriptionUpdated(Event $event): void
{
    $subscription = $event->data->object;

    $this->subscriptionService->updateSubscription(
        $subscription->id,
        $subscription->status,
        $subscription->current_period_end ?? null
    );
}

protected function handleSubscriptionDeleted(Event $event): void
{
    $subscription = $event->data->object;

    $this->subscriptionService->cancel(
        $subscription->id
    );
}
}