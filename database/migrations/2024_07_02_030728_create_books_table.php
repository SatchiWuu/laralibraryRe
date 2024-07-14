<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('publication');
            $table->string('genre');
            $table->string('language');
            $table->string('reviews')->nullable(true);
            $table->string('images')->nullable(true);
            $table->string('summary')->nullable(true);

            
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->on('authors')->references('id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
