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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('discount_percentage');
            $table->boolean('is_active')->default(true);
            $table->integer('usage_limit')->nullable(); // nullable لتركها مفتوحة إذا لم يكن هناك حد للاستخدام
            $table->dateTime('expiry_date')->nullable(); // nullable لتركها مفتوحة إذا لم يكن هناك تاريخ انتهاء
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
