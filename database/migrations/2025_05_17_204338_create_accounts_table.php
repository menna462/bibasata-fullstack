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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId(column: 'bundle_id')->nullable()->constrained()->onDelete('cascade');

            $table->foreignId('duration_price_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('duration_in_days');
            $table->integer('max_users')->default(1);
            $table->integer('current_users')->default(0);
            $table->boolean('is_full')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
