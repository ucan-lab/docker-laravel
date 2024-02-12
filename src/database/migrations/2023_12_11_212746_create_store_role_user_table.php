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
        Schema::create('store_role_user', function (Blueprint $table) {
            $table->comment('ストアロールとユーザーの中間TBL');

            $table->id();
            $table->foreignId('store_role_id')->constrained('store_role')->cascadeOnDelete()->comment('ストアロールID');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_role_user');
    }
};
