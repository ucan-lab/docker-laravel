<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RouteActionTarget;

class RouteActionTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = RouteActionTarget::ROUTE_ACTION_TARGETS;

        DB::table('route_action_target')->insert($data);
    }
}
