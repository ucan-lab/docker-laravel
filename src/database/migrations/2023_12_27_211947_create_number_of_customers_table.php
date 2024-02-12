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
        Schema::create('number_of_customers', function (Blueprint $table) {
            $table->comment('客数');

            $table->id();
            $table->foreignId('bill_id')->constrained('bills')->cascadeOnDelete()->comment('伝票ID');
            $table->smallInteger('arrival')->comment('来店時客数');
            $table->smallInteger('join')->default(0)->comment('追加来店客集');
            $table->smallInteger('leave')->default(0)->comment('途中退店客数');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number_of_customers');
    }
};
