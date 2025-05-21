<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librarian extends Model
{
      protected $fillable = [
        'id',
        'employee_id',
        'designation',
        'specialization',
        'can_approve_requests',
        
        'can_manage_catalog',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }

    use HasFactory;
}
