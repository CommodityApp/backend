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
            $table->decimal('amount', 14, 4);
            $table->decimal('error', 12, 4)->default(1);
            $table->integer('batch_quantity');
            $table->json('batch_inputs');
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
