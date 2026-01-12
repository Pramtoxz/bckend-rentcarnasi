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

        // Skip SSL verification to avoid cURL error 77 in local/dev environments
        if (config('app.env') !== 'production') {
            $this->client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

            // Backup fix: point to the correct cacert.pem dynamically
            putenv('CURL_CA_BUNDLE=C:\laragon\etc\ssl\cacert.pem');
            putenv('SSL_CERT_FILE=C:\laragon\etc\ssl\cacert.pem');
        }

        $this->client->setAuthConfig(base_path('fcm.json'));
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        $this->client->fetchAccessTokenWithAssertion();
        $accessToken = $this->client->getAccessToken();

        $tokenValue = $accessToken['access_token'];
        $projectId = env('FCM_PROJECT_ID');

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'android' => [
                    'priority' => 'high',
                ],
            ],
        ];

        if (!empty($data)) {
            // FCM v1 requires all values in data to be strings
            $payload['message']['data'] = array_map(function ($value) {
                return (string) $value;
            }, $data);
        }

        $request = Http::withToken($tokenValue)
            ->withHeaders(['Content-Type' => 'application/json']);

        if (config('app.env') !== 'production') {
            $request->withoutVerifying();
        }

        $response = $request->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

        if ($response->failed()) {
            Log::error("FCM Send Failed: " . $response->body());
            return false;
        }

        return $response->json();
    }

    public function sendVerificationNotification($user, $status, $catatan = null)
    {
        if (!$user->fcm_token) {
            return false;
        }

        $title = $status === 'verified'
            ? '✅ Verifikasi Berhasil'
            : '❌ Verifikasi Ditolak';

        $body = $status === 'verified'
            ? 'Selamat! Akun Anda telah diverifikasi. Anda sekarang dapat melakukan booking mobil.'
            : 'Maaf, verifikasi akun Anda ditolak. ' . ($catatan ?? 'Silakan hubungi admin untuk informasi lebih lanjut.');

        $data = [
            'type' => 'user_verification',
            'status' => $status,
            'catatan' => $catatan ?? '',
        ];

        return $this->sendNotification($user->fcm_token, $title, $body, $data);
    }

    public function sendPaymentVerificationNotification($booking, $status, $catatan = null)
    {
        $user = $booking->user;

        if (!$user->fcm_token) {
            return false;
        }

        $title = $status === 'verified'
            ? '✅ Pembayaran Diverifikasi'
            : '❌ Pembayaran Ditolak';

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
            'pending' => '⏳ Booking Menunggu',
            'verified' => '✅ Booking Dikonfirmasi',
            'checked_in' => '🚗 Mobil Siap Diambil',
            'completed' => '✔️ Booking Selesai',
            'cancelled' => '❌ Booking Dibatalkan',
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
}
