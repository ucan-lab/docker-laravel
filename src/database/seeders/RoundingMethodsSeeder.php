<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RoundingMethod;

class RoundingMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = RoundingMethod::getAllMethods();

        // DB::table('rounding_methods')->insert($data);
        foreach ($datas as $data) {
            RoundingMethod::insert([
                'id' => $data['id'],
                'rounding_method' => $data['rounding_method'],
            ]);
        }
    }
}
