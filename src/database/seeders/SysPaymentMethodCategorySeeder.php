<?php

namespace Database\Seeders;

use App\Models\SysPaymentMethodCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SysPaymentMethodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = SysPaymentMethodCategory::SYS_PAYMENT_METHOD_CATEGORIES;
        $SysPaymentMethodCategories = [];
        foreach ($datas as $data) {
            $SysPaymentMethodCategories[] = $data;
        }

        DB::table('sys_payment_method_categories')->insert($SysPaymentMethodCategories);
    }
}
