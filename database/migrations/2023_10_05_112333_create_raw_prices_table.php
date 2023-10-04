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
            Schema::create('raw_prices', function (Blueprint $table) {
                $table->id();
                $table->decimal('price', 14, 4);
                $table->timestamps();
                $table->unsignedInteger('order_column')->nullable();

                $table->foreignId('raw_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('price_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

                $table->unique(['raw_id', 'price_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_prices');
    }
};
