<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\ConfigWA as WA;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'admin',
            'nohp' => '082287140724',
            'status_verifikasi' => 'verified',
        ]);

        WA::create([
            'wa_gateway_url' => 'https://wa-gateway.myserverku.web.id',
            'wa_gateway_secret' => 'OkYes!23*&!@%dsjPOETasdk',
            'wa_session_name' => 'attaya',
            'wa_group_id' => '120363421970612390@g.us',
        ]);
    }
}
