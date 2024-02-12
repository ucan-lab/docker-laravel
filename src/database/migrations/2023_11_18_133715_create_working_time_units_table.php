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
        Schema::create('working_time_units', function (Blueprint $table) {
            $table->comment('労働時間単位');

            $table->bigInteger('id')->primary();
            $table->integer('minutes')->unique()->comment('勤務時間単位(分)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_time_units');
    }
};
