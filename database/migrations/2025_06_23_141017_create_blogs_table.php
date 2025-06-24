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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();          
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();                
            $table->string('image')->nullable();
            $table->text('content'); 
            $table->timestamp('published_at')->nullable();
            $table->string('status')->default('draft');
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->integer('reading_time')->nullable();   
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
