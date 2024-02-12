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
        Schema::create('group_user', function (Blueprint $table) {
            $table->comment('グループとユーザーの中間TBL');

            $table->id();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete()->comment('グループID');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
