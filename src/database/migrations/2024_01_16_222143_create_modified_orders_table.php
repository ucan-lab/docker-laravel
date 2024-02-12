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
        Schema::create('modified_orders', function (Blueprint $table) {
            $table->comment('調整後注文');

            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('元の注文');
            $table->integer('modified_amount')->nullable()->comment('調整後金額');
            $table->boolean('modified_is_service_included')->nullable()->comment('サービス料を含む');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modified_orders');
    }
};
