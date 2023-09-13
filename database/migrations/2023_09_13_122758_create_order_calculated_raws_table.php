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
            $table->float('ratio')->nullable();
            $table->json('calculated_amount')->nullable();
            $table->json('calculated_amount_with_error')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('raw_id')->nullable();

            $table->unique(['order_id', 'raw_id']);
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
