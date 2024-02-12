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
        Schema::create('orders', function (Blueprint $table) {
            $table->comment('注文');

            $table->id();

            $table->foreignId('itemized_order_id')->constrained('itemized_orders')->cascadeOnDelete()->comment('一連の注文ID');
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete()->comment('メニューID');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
