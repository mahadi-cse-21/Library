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

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->unsignedBigInteger('category_id')->nullable(); // Uncommented and made nullable
            $table->string('author');
            

            $table->text('description')->nullable();
            $table->string('language', 50)->nullable();
            $table->enum('status', ['available', 'processsing', 'reserved','stock out'])->default('available');
            $table->integer('pages')->nullable();
            $table->string('cover', 255)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('available_quantity')->default(0);
            $table->timestamps();$table->int('rating')->default(0);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('set null'); // Ensure this foreign key constraint is properly formed

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
    }
};
