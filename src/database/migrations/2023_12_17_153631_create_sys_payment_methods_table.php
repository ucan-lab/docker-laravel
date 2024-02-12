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
        Schema::create('sys_payment_method_categories', function (Blueprint $table) {
            $table->comment('システム_支払い方法カテゴリ');

            $table->bigInteger('id')->primary();
            $table->string('name')->comment('カテゴリ名');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_payment_method_categories');
    }
};
