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
        Schema::create('role_route_action_target', function (Blueprint $table) {
            $table->comment('ロールと操作の中間TBL');

            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->comment('ロールID');
            $table->foreignId('route_action_target_id')->constrained('route_action_target')->cascadeOnDelete()->comment('操作ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_route_action_target');
    }
};
