<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ConsumptionTaxType;

class ConsumptionTaxTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ConsumptionTaxType::getAllTypes();

        DB::table('consumption_tax_types')->insert($data);
    }
}
