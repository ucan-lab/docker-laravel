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
        Schema::create('rounding_methods', function (Blueprint $table) {
            $table->comment('丸め方法');

            $table->bigInteger('id')->primary();
            $table->string('rounding_method')->unique()->comment('丸め方法');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounding_methods');
    }
};
