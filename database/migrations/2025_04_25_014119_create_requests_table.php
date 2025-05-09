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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('book_copy_id', 100);  // Change this to string, matching the type in book_copies table
            $table->enum('type', ['request', 'reserve']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('requested_date')->default(null);
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('book_copy_id')->references('book_copy_id')->on('book_copies')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
