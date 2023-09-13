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
        Schema::create('raw_receipts', function (Blueprint $table) {
            $table->id();
            $table->float('ratio')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('raw_id');
            $table->unsignedBigInteger('receipt_id');

            $table->unique(['raw_id', 'receipt_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_receipts');
    }
};
