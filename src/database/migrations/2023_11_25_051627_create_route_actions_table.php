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
        Schema::create('route_actions', function (Blueprint $table) {
            // テーブル論理名
            $table->comment('ルートアクションマスタ');

            $table->unsignedBigInteger('id')->unique();
            $table->string('name')->unique()->comment('Controller@method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_actions');
    }
};
