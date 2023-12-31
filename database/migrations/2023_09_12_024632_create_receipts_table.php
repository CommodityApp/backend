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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate', 14, 4)->nullable();
            $table->string('code')->nullable()->unique();
            $table->string('name')->nullable();
            $table->string('unit')->nullable();
            $table->string('producer_name')->nullable();
            $table->decimal('concentration', 14, 4)->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('animal_type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
