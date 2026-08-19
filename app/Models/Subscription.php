<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'student_id',
    'fee_id',
    'stripe_customer_id',
    'stripe_subscription_id',
    'stripe_invoice_id',
    'amount',
    'currency',
    'status',
    'current_period_end'
])]
class Subscription extends Model
{
    protected function casts(): array
    {
        return [
            'current_period_end' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

 // app/Models/Subscription.php
public function webhookEvents()
{
    return $this->hasMany(
        WebhookEvent::class,
        'stripe_subscription_id',  // webhook_events table ka column
        'stripe_subscription_id'   // subscriptions table ka column
    );
}
}