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
        Schema::create('store_details', function (Blueprint $table) {
            $table->comment('店舗設定詳細');

            $table->id();
            $table->foreignId('store_id')->constrained('stores')->comment('店舗ID');

            $table->string('invoice_registration_number')->nullable()->comment('インボイス登録番号');

            $table->smallInteger('service_rate')->unsigned()->comment('サービス料率');
            $table->foreignId('service_rate_digit_id')->constrained('digits')->comment('サービス料丸め単位');
            $table->foreignId('service_rate_rounding_method_id')->constrained('rounding_methods')->comment('サービス料丸め方法');

            $table->smallInteger('consumption_tax_rate')->unsigned()->comment('消費税率');
            $table->foreignId('consumption_tax_rate_digit_id')->constrained('digits')->comment('消費税丸め単位');
            $table->foreignId('consumption_tax_rate_rounding_method_id')->constrained('rounding_methods')->comment('消費税丸め方法');
            $table->foreignId('consumption_tax_type_id')->constrained('consumption_tax_types')->comment('消費税表記');

            $table->foreignId('user_incentive_digit_id')->constrained('digits')->comment('ユーザーインセンティブ金額丸め単位');
            $table->foreignId('user_incentive_rounding_method_id')->constrained('rounding_methods')->comment('ユーザーインセンティブ金額丸め方法');

            $table->timestamp('created_at')->nullable();
            $table->unique(['created_at', 'store_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_details');
    }
};
