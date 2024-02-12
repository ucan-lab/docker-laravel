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
        Schema::create('consumption_tax_types', function (Blueprint $table) {
            $table->comment('消費税表記');

            $table->bigInteger('id')->primary();
            $table->string('type')->unique()->comment('消費税表記');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumption_tax_types');
    }
};
