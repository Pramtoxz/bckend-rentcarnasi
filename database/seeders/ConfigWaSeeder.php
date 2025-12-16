<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigWaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('config_wa')->insert([
            'wa_gateway_url' => env('WA_GATEWAY_URL', 'http://localhost:3000'),
            'wa_gateway_secret' => env('WA_GATEWAY_SECRET', 'your-secret-token'),
            'wa_session_name' => env('WA_SESSION_NAME', 'default'),
            'wa_group_id' => env('WA_GROUP_ID', null),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
