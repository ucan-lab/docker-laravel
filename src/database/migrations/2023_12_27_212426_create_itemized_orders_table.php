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
        Schema::create('itemized_orders', function (Blueprint $table) {
            $table->comment('一連の注文');

            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete()->comment('伝票ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemized_orders');
    }
};
