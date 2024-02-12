<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Digit;

class DigitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = Digit::getAllDigits();

        foreach ($datas as $data) {
            Digit::insert([
                'id' => $data['id'],
                'digit' => $data['digit'],
            ]);
        }
    }
}
