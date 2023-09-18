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
        Schema::create('order_calculated_raws', function (Blueprint $table) {
            $table->id();
            $table->json('calculated_amount');
            $table->json('calculated_amount_with_error');
            $table->timestamps();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('receipt_raw_id')->nullable();

            $table->unique(['order_id', 'receipt_raw_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_calculated_raws');
    }
};
