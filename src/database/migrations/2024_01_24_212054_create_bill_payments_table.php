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
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete()->comment('伝票');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete()->comment('支払い方法');
            $table->integer('receipt_amount')->comment('受領金額');
            $table->integer('total_amount')->comment('合計金額');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
    }
};
