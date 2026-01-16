<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FCMService;
use App\Models\User;

class TestFCM extends Command
{
    protected $signature = 'fcm:test {user_id?}';
    protected $description = 'Test FCM notification untuk user tertentu';

    public function handle(FCMService $fcmService)
    {
        $userId = $this->argument('user_id');
        
        if (!$userId) {
            // Tampilkan daftar user yang punya FCM token
            $users = User::whereNotNull('fcm_token')->get(['id', 'name', 'nohp', 'fcm_token']);
            
            if ($users->isEmpty()) {
                $this->error('Tidak ada user dengan FCM token!');
                return 1;
            }
            
            $this->info('Daftar user dengan FCM token:');
            foreach ($users as $user) {
                $this->line("ID: {$user->id} | {$user->name} | {$user->nohp} | Token: " . substr($user->fcm_token, 0, 30) . '...');
            }
            
            $userId = $this->ask('Masukkan User ID untuk test');
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            $this->error("User dengan ID {$userId} tidak ditemukan!");
            return 1;
        }
        
        if (!$user->fcm_token) {
            $this->error("User {$user->name} tidak memiliki FCM token!");
            return 1;
        }
        
        $this->info("Mengirim test notification ke: {$user->name}");
        $this->info("FCM Token: " . substr($user->fcm_token, 0, 50) . '...');
        
        $result = $fcmService->sendNotification(
            $user->fcm_token,
            'Test Notification',
            'Ini adalah test notification dari Laravel',
            ['test' => 'true', 'timestamp' => now()->toDateTimeString()]
        );
        
        if ($result) {
            $this->info('✅ Notifikasi berhasil dikirim!');
            $this->line('Response: ' . json_encode($result, JSON_PRETTY_PRINT));
            return 0;
        } else {
            $this->error('❌ Gagal mengirim notifikasi!');
            $this->warn('Cek log di storage/logs/laravel.log untuk detail error');
            return 1;
        }
    }
}
