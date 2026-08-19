<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $fillable = [
        'stripe_event_id',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'stripe_subscription_id',
        'stripe_invoice_id',
        'type',
        'payload',
        'processed',
        'error_message',
    ];

    protected $casts = [
    'payload' => 'array',
];

    /**
     * Relationship with Payment using Stripe Payment Intent ID
     */
    public function payment()
    {
        return $this->belongsTo(
            Payment::class,
            'stripe_payment_intent_id', // column in webhook_events
            'stripe_payment_id'         // column in payments
        );
    }

    /**
     * Relationship with Subscription using Stripe Subscription ID
     */
    public function subscription()
    {
        return $this->belongsTo(
            Subscription::class,
            'stripe_subscription_id',      // column in webhook_events
            'stripe_subscription_id'       // column in subscriptions
        );
    }
}