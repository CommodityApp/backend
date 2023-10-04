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
        Schema::withoutForeignKeyConstraints(function () {
            Schema::create('order_calculated_raws', function (Blueprint $table) {
                $table->id();
                $table->json('calculated_amount');
                $table->json('calculated_amount_with_error');
                $table->timestamps();

                $table->decimal('ratio', 14, 4)->nullable();
                $table->decimal('price', 14, 4)->nullable();
                $table->foreignId('raw_price_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('order_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('receipt_raw_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

                $table->unique(['order_id', 'receipt_raw_id']);
            });
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
