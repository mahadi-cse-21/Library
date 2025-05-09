<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    protected $fillable = [
        'student_id',
        'book_copy_id',
        'type',
        'status'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(Book_Copy::class,'book_copy_id','book_copy_id');
    }

    use HasFactory;
}
