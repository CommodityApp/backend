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
        Schema::create('raws', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('unit')->nullable();
            $table->string('concentration')->nullable();
            $table->string('batch_number')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('raw_type_id')->nullable();
            $table->unsignedBigInteger('producer_id')->nullable();
            $table->unsignedBigInteger('bunker_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('last_raw_price_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raws');
    }
};
