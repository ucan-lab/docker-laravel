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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('display_name')->comment('表示名');
            $table->string('email')->nullable()->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス認証日時');
            $table->string('password')->nullable()->comment('パスワード');
            $table->string('icon_img')->nullable()->comment('アイコンイメージ');
            $table->string('real_name')->nullable()->comment('本名');
            $table->string('tel_number')->nullable()->comment('電話番号');
            $table->date('birth_day')->nullable()->comment('生年月日');
            $table->string('postal_code')->nullable()->comment('郵便番号');
            $table->string('address')->nullable()->comment('住所');
            $table->text('note')->nullable()->comment('備考');
            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
