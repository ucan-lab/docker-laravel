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
        Schema::create('bills', function (Blueprint $table) {
            $table->comment('伝票');

            $table->id();
            $table->foreignId('business_date_id')->constrained('business_dates')->cascadeOnDelete()->comment('営業日付ID');
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete()->comment('店舗ID');
            $table->dateTime('arrival_time')->comment('来店日時');
            $table->dateTime('departure_time')->nullable()->comment('退店日時');

            $table->foreignId('store_detail_id')->constrained('store_details')->cascadeOnDelete()->comment('店舗詳細ID');
            $table->smallInteger('service_rate')->unsigned()->comment('サービス料率');
            $table->smallInteger('consumption_tax_rate')->unsigned()->comment('消費税率');

            $table->integer('discount_amount')->default(0)->comment('値引き金額');
            $table->text('discount_note')->nullable()->comment('値引きメモ');

            $table->boolean('receipt_issued')->default(false)->comment('レシート発行有無');
            $table->boolean('invoice_issued')->default(false)->comment('領収書発行有無');

            $table->text('memo')->nullable()->comment('メモ');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
