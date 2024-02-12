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
        Schema::create('general_users', function (Blueprint $table) {
            $table->comment('一般ユーザーTBL');

            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');
            $table->boolean('can_login')->comment('ログイン可否');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_users');
    }
};
