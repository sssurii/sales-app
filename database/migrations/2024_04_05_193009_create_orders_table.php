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
            $table->foreignId('user_id');
            $table->foreignId('table_id');
            $table->string('status', 255);
            $table->string('placed_by', 255);
            $table->string('served_by', 255);
            $table->text('customer_notes');
            $table->text('internal_notes');
            $table->decimal('sub_total', 8, 2);
            $table->decimal('tax', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->string('discount_type', 255);
            $table->decimal('total_price', 8, 2);
            $table->string('payment_method', 255);
            $table->string('payment_reference', 255);
            $table->boolean('payment_received')->default(false);
            $table->softDeletes();
            $table->timestamps();
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
