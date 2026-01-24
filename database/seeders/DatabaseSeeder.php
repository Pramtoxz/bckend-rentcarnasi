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
            'nohp' => '6282287140724',
            'status_verifikasi' => 'verified',
        ]);

        WA::create([
            'wa_gateway_url' => 'https://api-wa.albiruni.sch.id',
            'wa_gateway_secret' => '718272395fd1bb4f72dc14dd8a5c731c79de7d25284a2faf5749cfc3822284d5',
            'wa_session_name' => 'hello',
            'wa_group_id' => '120363421970612390@g.us',
        ]);
    }
}
