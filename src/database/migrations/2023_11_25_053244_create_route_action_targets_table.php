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
        Schema::create('route_action_target', function (Blueprint $table) {
            // テーブル論理名
            $table->comment('操作マスタ');

            $table->unsignedBigInteger('id')->unique();
            $table->foreignId('route_action_id')->constrained('route_actions')->cascadeOnDelete()->comment('ルートアクションマスタ');
            $table->foreignId('target_id')->constrained('targets')->cascadeOnDelete()->comment('対象マスタ');
            $table->timestamps();

            // ユニーク制約
            $table->unique(['route_action_id', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_action_target');
    }
};
