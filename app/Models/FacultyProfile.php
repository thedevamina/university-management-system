<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'department_id', 'designation', 'employee_no'])]
class FacultyProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

  
public function documents()
{
    return $this->morphMany(Document::class, 'documentable');
}
}