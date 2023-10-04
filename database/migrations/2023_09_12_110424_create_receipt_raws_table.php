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
            Schema::create('receipt_raws', function (Blueprint $table) {
                $table->id();
                $table->decimal('ratio', 14, 4)->default(0);
                $table->unsignedInteger('order_column');
                $table->timestamps();

                $table->foreignId('raw_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('receipt_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

                $table->unique(['raw_id', 'receipt_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Schema::dropIfExists('receipt_raws');
        });

    }
};
