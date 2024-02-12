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
        Schema::create('itemized_set_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itemized_order_id')->constrained('itemized_orders')->cascadeOnDelete()->comment('一連の注文ID');

            $table->dateTime('start_at')->comment('セット開始日時');
            $table->dateTime('end_at')->nullable()->comment('セット終了日時');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemized_set_orders');
    }
};
