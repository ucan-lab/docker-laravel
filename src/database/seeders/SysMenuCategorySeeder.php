<?php

namespace Database\Seeders;

use App\Models\SysMenuCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysMenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = SysMenuCategory::CATEGORIES;

        DB::table('sys_menu_categories')->insert($data);
    }
}
