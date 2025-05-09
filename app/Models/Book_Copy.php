<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_Copy extends Model
{
    protected $table = 'book_copies';
    protected $fillable = ['book_id','book_copy_id', 'barcode', 'status'];
    public function book()
    {
        return $this->belongsTo(Book::class,'book_id','id');
    }
    use HasFactory;
}
