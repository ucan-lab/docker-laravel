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
        Schema::create('selection_orders', function (Blueprint $table) {
            $table->comment('指名注文');

            $table->id();
            $table->foreignId('itemized_set_order_id')->constrained('itemized_set_orders')->cascadeOnDelete()->comment('同一セット注文ID');
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('注文ID');

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selection_orders');
    }
};
