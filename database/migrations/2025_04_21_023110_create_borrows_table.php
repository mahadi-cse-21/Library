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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('book_copy_id',100);
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->decimal('fine_amount', 10, 2)->default(0.00);
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            $table->unsignedBigInteger('issued_by_librarian_id');
            $table->unsignedBigInteger('received_by_librarian_id')->nullable();
            $table->timestamps();
        
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('book_copy_id')->references('book_copy_id')->on('book_copies')->onDelete('cascade');
            $table->foreign('issued_by_librarian_id')->references('id')->on('librarians')->onDelete('restrict');
            $table->foreign('received_by_librarian_id')->references('id')->on('librarians')->onDelete('restrict');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrows');
    }
};
