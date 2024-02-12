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
        Schema::create('attendances', function (Blueprint $table) {
            $table->comment('勤怠TBL');

            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');
            $table->foreignId('business_date_id')->constrained('business_dates')->cascadeOnDelete()->comment('営業日付ID');

            $table->dateTime('working_start_at')->nullable()->comment('勤務開始日時');
            $table->dateTime('working_end_at')->nullable()->comment('勤務終了日時');

            $table->integer('break_total_minute')->default(0)->comment('休憩総時間（分単位）');
            $table->integer('late_total_minute')->default(0)->comment('遅刻総時間（分単位）');
            $table->boolean('absence')->default(false)->comment('当日欠勤');
            $table->boolean('unauthorized_absence')->default(false)->comment('無断欠勤');

            $table->integer('payment_amount')->nullable()->comment('支給金額');
            $table->enum('payment_type', ['full_day', 'advance'])->nullable()->comment('支給種別');
            $table->enum('payment_source', ['cash_register', 'other'])->nullable()->comment('支給元');

            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();

            // 同一ユーザー、同一営業日付のレコードはユニークであることを示す制約
            $table->unique(['user_id', 'business_date_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
