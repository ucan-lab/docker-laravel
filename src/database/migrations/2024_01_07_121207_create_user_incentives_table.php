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
        Schema::create('user_incentives', function (Blueprint $table) {
            $table->comment('ユーザーインセンティブ');

            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete()->comment('注文ID');
            $table->integer('amount')->comment('金額');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_incentives');
    }
};
