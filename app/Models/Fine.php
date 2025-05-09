<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'borrow_id', 
        'student_id', 
        'amount', 
        'reason', 
        'is_paid', 
        'paid_at',
        'collected_by_librarian_id'
    ];
    
    protected $casts = [
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];
    
    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function librarian()
    {
        return $this->belongsTo(Librarian::class, 'collected_by_librarian_id');
    }
}
