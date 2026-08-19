<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['fee_id', 'student_id', 'stripe_session_id', 'stripe_payment_id', 'amount', 'currency', 'status'])]
class Payment extends Model
{
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

public function webhookEvents()
{
    return $this->hasMany(
        WebhookEvent::class,
        'stripe_payment_intent_id', 
        'stripe_payment_id'         
    );
}
}