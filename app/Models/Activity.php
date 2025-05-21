<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'student_id',
        'action_type',
        'description',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public static function log($action_type, $description, $userId = null, $bookId = null, $studentId = null, $data = [])
    {
        return self::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'student_id' => $studentId,
            'action_type' => $action_type,
            'description' => $description,
            'data' => $data,
        ]);
    }

    // Scopes
    public function scopeOfType($query, $type)
    {
        return $query->where('action_type', $type);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

}
