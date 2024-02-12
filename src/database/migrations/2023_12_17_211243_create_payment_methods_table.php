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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->comment('支払い方法');

            $table->id();
            $table->foreignId('sys_payment_method_category_id')->constrained('sys_payment_method_categories')->comment('システム支払い方法カテゴリID');
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete()->comment('ストアID');
            $table->string('name')->comment('名称');
            $table->string('code')->default('0')->comment('支払いコード');
            $table->integer('order')->nullable()->comment('表示順序');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
