<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{

    
    use HasFactory;
    protected $fillable = [
        'student_id',
        'book_id',
        'issue_date',
        'due_date',
        'return_date',
        'fine_amount',
        'status',
        'issued_by_librarian_id',
        'received_by_librarian_id',
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class); // Adjust to your actual student model
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

  
}
