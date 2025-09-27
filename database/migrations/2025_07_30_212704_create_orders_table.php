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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // يجب أن يكون إما product_id أو bundle_id مرتبطاً بالطلب، وليس كلاهما.
            // لذا، كلاهما يجب أن يكون nullable.
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('bundle_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('duration_in_days');
            $table->timestamp('order_date')->useCurrent();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_paid')->default(false); // عمود حالة الدفع

            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
