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
        Schema::create('tables', function (Blueprint $table) {
            $table->comment('テーブルマスタ');

            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete()->comment('ストアID');
            $table->string('name')->comment('テーブル名');
            $table->boolean('display')->comment('表示/非表示');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
