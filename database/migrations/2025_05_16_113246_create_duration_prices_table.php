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
        Schema::create('duration_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId(column: 'bundle_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('duration_in_months'); // مثلاً 1، 3، 6 شهور
            $table->decimal('price_usd', 8, 2);
            $table->decimal('price_egp', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duration_prices');
    }
};
