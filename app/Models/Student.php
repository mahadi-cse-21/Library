<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', // user_id
        'student_id',
        'department',
        'year',
        'semester',
        'status',
        'max_allowed_books',
        'current_borrows',
        'book_borrowed'
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
    
}
