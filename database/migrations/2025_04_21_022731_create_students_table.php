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
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // id = user_id
            $table->string('student_id', 12)->unique();
            $table->string('department', 100);
            $table->enum('year', ['1st year', '2nd year', '3rd year', '4th year'])->nullable();

            $table->enum('semester', ['1st','2nd'])->nullable();
            $table->date('graduation_date')->nullable();
            $table->enum('status',['active','suspend','inactive','graduated'])->default('active');
            $table->unsignedInteger('max_allowed_books')->default(5);
            $table->unsignedInteger('current_borrows')->default(0);
            $table->unsignedInteger('book_borrowed')->default(0);
            $table->timestamps();
        
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
