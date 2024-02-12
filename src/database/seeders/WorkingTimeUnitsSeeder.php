<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WorkingTimeUnit;

class WorkingTimeUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = WorkingTimeUnit::getAllUnits();

        DB::table('working_time_units')->insert($data);
    }
}
