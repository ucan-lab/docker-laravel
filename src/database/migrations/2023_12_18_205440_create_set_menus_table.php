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
        Schema::create('set_menus', function (Blueprint $table) {
            $table->comment('セットメニュー');

            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete()->comment('メニューID');
            $table->integer('minutes')->comment('時間(分)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_menus');
    }
};
