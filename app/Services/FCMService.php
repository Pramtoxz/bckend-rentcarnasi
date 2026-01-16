<?php

namespace App\Services;

use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FCMService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(base_path('fcm.json'));
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        try {
            $this->client->fetchAccessTokenWithAssertion();
            $accessToken = $this->client->getAccessToken();
            
            if (!$accessToken || !isset($accessToken['access_token'])) {
                Log::error('FCM: Failed to get access token', ['accessToken' => $accessToken]);
                return false;
            }
            
            $tokenValue = $accessToken['access_token'];
            $projectId = env('FCM_PROJECT_ID');

            if (!$projectId) {
                Log::error('FCM: FCM_PROJECT_ID not set in .env');
                return false;
            }

            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                    'data' => $data,
                    'android' => [
                        'priority' => 'high',
                    ],
                ],
            ];

            Log::info('FCM: Sending notification', [
                'token' => substr($token, 0, 20) . '...',
                'title' => $title,
                'projectId' => $projectId
            ]);

            $response = Http::withToken($tokenValue)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

            if ($response->failed()) {
                Log::error('FCM: Failed to send notification', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'token' => substr($token, 0, 20) . '...'
                ]);
                return false;
            }

            Log::info('FCM: Notification sent successfully', ['response' => $response->json()]);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('FCM: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    public function sendVerificationNotification($user, $status, $catatan = null)
    {
        if (!$user->fcm_token) {
            Log::warning('FCM: User has no FCM token', ['user_id' => $user->id]);
            return false;
        }

        $title = $status === 'verified' 
            ? 'Verifikasi Berhasil' 
            : 'Verifikasi Ditolak';
        
        $body = $status === 'verified'
            ? 'Selamat! Akun Anda telah diverifikasi. Anda sekarang dapat melakukan booking mobil.'
            : 'Maaf, verifikasi akun Anda ditolak. ' . ($catatan ?? 'Silakan hubungi admin untuk informasi lebih lanjut.');

        $data = [
            'type' => 'user_verification',
            'status' => $status,
            'catatan' => $catatan ?? '',
        ];

        Log::info('FCM: Sending verification notification', [
            'user_id' => $user->id,
            'status' => $status
        ]);

        return $this->sendNotification($user->fcm_token, $title, $body, $data);
    }

    public function sendPaymentVerificationNotification($booking, $status, $catatan = null)
    {
        $user = $booking->user;
        
        if (!$user->fcm_token) {
            return false;
        }

        $title = $status === 'verified' 
            ? 'Pembayaran Diverifikasi' 
            : 'Pembayaran Ditolak';
        
        $body = $status === 'verified'
            ? "Pembayaran booking {$booking->kode_booking} telah diverifikasi. Silakan ambil mobil sesuai jadwal."
            : "Pembayaran booking {$booking->kode_booking} ditolak. " . ($catatan ?? 'Silakan upload ulang bukti pembayaran yang valid.');

        $data = [
            'type' => 'payment_verification',
            'booking_id' => $booking->id,
            'kode_booking' => $booking->kode_booking,
            'status' => $status,
            'catatan' => $catatan ?? '',
        ];

        return $this->sendNotification($user->fcm_token, $title, $body, $data);
    }

    public function sendBookingStatusNotification($booking, $status, $message)
    {
        $user = $booking->user;
        
        if (!$user->fcm_token) {
            return false;
        }

        $titles = [
            'pending' => 'Booking Menunggu',
            'verified' => 'Booking Dikonfirmasi',
            'checked_in' => 'Mobil Siap Diambil',
            'completed' => 'Booking Selesai',
            'cancelled' => 'Booking Dibatalkan',
        ];

        $title = $titles[$status] ?? 'Update Booking';

        $data = [
            'type' => 'booking_status',
            'booking_id' => $booking->id,
            'kode_booking' => $booking->kode_booking,
            'status' => $status,
        ];

        return $this->sendNotification($user->fcm_token, $title, $message, $data);
    }


    public function sendBroadcastNotification($user, $title, $message, $broadcastData = [])
    {
        if (!$user->fcm_token) {
            Log::warning('FCM: User has no FCM token for broadcast', ['user_id' => $user->id]);
            return false;
        }

        $data = array_merge([
            'type' => 'broadcast',
        ], $broadcastData);

        Log::info('FCM: Sending broadcast notification', [
            'user_id' => $user->id,
            'title' => $title,
            'broadcast_id' => $broadcastData['broadcast_id'] ?? null
        ]);

        return $this->sendNotification($user->fcm_token, $title, $message, $data);
    }
}