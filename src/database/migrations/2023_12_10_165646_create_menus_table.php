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
        Schema::create('menus', function (Blueprint $table) {
            $table->comment('メニュー');

            $table->id();
            $table->foreignId('menu_category_id')->constrained('menu_categories')->cascadeOnDelete()->comment('メニューカテゴリID');
            $table->string('name')->comment('名称');
            $table->integer('price')->comment('金額');
            $table->integer('insentive_persentage')->nullable()->comment('インセンティブ:%');
            $table->integer('insentive_amount')->nullable()->comment('インセンティブ:金額');
            $table->string('code')->default('0')->comment('メニューコード');
            $table->integer('order')->nullable()->comment('表示順序');
            $table->boolean('display')->default(true)->comment('表示/非表示');
            $table->timestamps();
            $table->softDeletes();
        });

        // インセンティブはパーセンテージ、金額両方に値が入っていないという制約
        DB::unprepared('
            CREATE OR REPLACE FUNCTION check_insentive()
            RETURNS TRIGGER AS $$
            BEGIN
                IF NEW.insentive_persentage IS NOT NULL AND NEW.insentive_amount IS NOT NULL THEN
                    RAISE EXCEPTION \'Either insentive_persentage or insentive_amount must be NULL\';
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER menus_check_insentive
            BEFORE INSERT OR UPDATE ON menus
            FOR EACH ROW EXECUTE FUNCTION check_insentive();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS menus_check_insentive ON menus;');
        DB::unprepared('DROP FUNCTION IF EXISTS check_insentive();');
        Schema::dropIfExists('menus');
    }
};
