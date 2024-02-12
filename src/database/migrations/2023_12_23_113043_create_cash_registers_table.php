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
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->comment('レジ金TBL');

            $table->id();
            $table->foreignId('business_date_id')->constrained('business_dates')->cascadeOnDelete()->comment('営業日付ID');

            $table->unsignedInteger('cash_at_opening')->default(0)->comment('営業開始時点釣銭合計');

            $table->unsignedInteger('ten_thousand')->default(0)->comment('営業終了時点1万円札数');
            $table->unsignedInteger('five_thousand')->default(0)->comment('営業終了時点5千円札数');
            $table->unsignedInteger('two_thousand')->default(0)->comment('営業終了時点2千円札数');
            $table->unsignedInteger('one_thousand')->default(0)->comment('営業終了時点1千円札数');
            $table->unsignedInteger('five_hundred')->default(0)->comment('営業終了時点500円玉数');
            $table->unsignedInteger('hundred')->default(0)->comment('営業終了時点100円玉数');
            $table->unsignedInteger('fifty')->default(0)->comment('営業終了時点50円玉数');
            $table->unsignedInteger('ten')->default(0)->comment('営業終了時点10円玉数');
            $table->unsignedInteger('five')->default(0)->comment('営業終了時点5円玉数');
            $table->unsignedInteger('one')->default(0)->comment('営業終了時点1円玉数');
            $table->text('memo')->nullable()->comment('メモ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_registers');
    }
};
