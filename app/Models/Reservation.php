<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    use HasFactory;

    protected $fillable = [
        'student_id',
        'book_id',
        'reservation_date',
        'expiry_date',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the book that was reserved.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
