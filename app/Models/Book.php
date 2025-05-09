<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'category_id',
        'author',
        'language',
        'pages',
        'price',
        'status',
        'quantity',
        'available_quantity',
        'description',
        'cover',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function book_copy()
    {
        return $this->hasMany(Book_Copy::class);
    }



    use HasFactory;
}
