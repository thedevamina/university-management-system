<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'documentable_id',
        'documentable_type',
    ];

  
    public function documentable()
    {
        return $this->morphTo();
    }
}