<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('book_id'); // Foreign key to books table
            $table->string('book_copy_id', 100)->unique(); // Unique identifier for each book copy
            $table->string('barcode', 50)->unique(); // Unique barcode for each book copy
            $table->enum('status', ['available', 'borrowed', 'reserved', 'damaged', 'lost'])->default('available');
            $table->enum('condition', ['new', 'excellent', 'good', 'fair', 'poor'])->default('good');
            $table->date('purchase_date')->nullable(); // Optional purchase date
            $table->timestamps(); // Created and updated timestamps
        
            // Foreign key relationship
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_copies');
    }
};
