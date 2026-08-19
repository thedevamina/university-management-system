<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['student_id', 'semester', 'amount', 'status', 'due_date', 'paid_at'])]
class Fee extends Model
{
    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}
public function subscription()
{
    return $this->hasOne(Subscription::class);
}
}