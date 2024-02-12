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
        Schema::create('stores', function (Blueprint $table) {
            $table->comment('店舗設定');

            $table->id();
            $table->foreignId('group_id')->constrained('groups')->comment('グループID');

            $table->string('name')->comment('店舗名');
            $table->string('image_path')->nullable()->comment('店舗画像パス');
            $table->string('address')->nullable()->comment('住所');
            $table->string('postal_code')->nullable()->comment('郵便番号');
            $table->string('tel_number')->nullable()->comment('電話番号');
            $table->time('opening_time')->nullable()->comment('営業開始時間');
            $table->time('closing_time')->nullable()->comment('営業終了時間');
            $table->foreignId('working_time_unit_id')->constrained('working_time_units')->comment('勤務時間単位ID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
