<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->comment('メニューカテゴリ');

            $table->id();
            $table->foreignId('sys_menu_category_id')->constrained('sys_menu_categories')->comment('システム飲食カテゴリID');
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete()->comment('ストアID');
            $table->string('name')->comment('名称');
            $table->string('code')->default('0')->comment('カテゴリコード');
            $table->integer('order')->nullable()->comment('表示順序');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_categories');
    }
};
