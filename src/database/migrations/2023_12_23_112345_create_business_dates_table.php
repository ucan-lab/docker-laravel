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
        Schema::create('business_dates', function (Blueprint $table) {
            $table->comment('営業日付TBL');

            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete()->comment('ストアID');
            $table->date('business_date')->comment('営業日付');
            $table->dateTime('opening_time')->nullable()->comment('開店処理実施日時');
            $table->dateTime('closing_time')->nullable()->comment('閉店処理実施日時');
            $table->timestamps();

            // ユニーク制約を設定する
            $table->unique(['store_id', 'business_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_dates');
    }
};
