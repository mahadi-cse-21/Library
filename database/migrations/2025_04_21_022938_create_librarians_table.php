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
        Schema::create('librarians', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // id = user_id
            $table->string('employee_id', 20)->unique();
            $table->string('designation', 100);
            $table->string('specialization', 100)->nullable();
            $table->boolean('can_approve_requests')->default(false);
            $table->boolean('can_manage_catalog')->default(false);
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
        Schema::dropIfExists('librarians');
    }
};
