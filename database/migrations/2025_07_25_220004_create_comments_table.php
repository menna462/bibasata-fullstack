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
        Schema::create('comments', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // مين اللي علّق (ممكن يكون Null لو ضيف)
            $table->string('guest_name')->nullable();
            $table->text('content'); // محتوى التعليق
              $table->tinyInteger('rating')->nullable();
            $table->string('page_name')->default('homepage'); // عشان التعليق ممكن يكون على بوست، منتج، إلخ.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
