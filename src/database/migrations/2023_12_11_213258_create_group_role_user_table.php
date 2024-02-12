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
        Schema::create('group_role_user', function (Blueprint $table) {
            $table->comment('グループロールとユーザーの中間TBL');

            $table->id();
            $table->foreignId('group_role_id')->constrained('group_role')->cascadeOnDelete()->comment('グループロールID');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('ユーザーID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_role_user');
    }
};
