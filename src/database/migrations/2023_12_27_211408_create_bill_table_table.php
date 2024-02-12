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
        Schema::create('bill_table', function (Blueprint $table) {
            $table->comment('伝票とテーブルの中間TBL');

            $table->id();

            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete()->comment('伝票ID');
            $table->foreignId('table_id')->constrained('tables')->cascadeOnDelete()->comment('テーブルID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_table');
    }
};
