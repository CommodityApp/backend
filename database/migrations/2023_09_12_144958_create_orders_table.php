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
            $table->datetime('date')->nullable();
            $table->unsignedFloat('order_amount');
            $table->float('error');
            $table->integer('batch_quantity');
            $table->json('batch_calculation');
            $table->json('calculated_amount')->nullable();
            $table->json('calculated_amount_with_error')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('receipt_id')->nullable();
            $table->unsignedBigInteger('animal_type_id')->nullable();
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
