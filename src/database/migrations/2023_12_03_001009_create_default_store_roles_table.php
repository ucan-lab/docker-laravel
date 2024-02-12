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
        Schema::create('default_store_roles', function (Blueprint $table) {
            // テーブル論理名
            $table->comment('デフォルトストアロール');

            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->comment('ロールID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_store_roles');
    }
};
