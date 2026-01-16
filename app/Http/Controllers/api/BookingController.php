<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Providers\WhatsAppGateway;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function faktur(Request $request, $id)
    {
        if ($request->has('token')) {
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($request->token);
            if ($accessToken) {
                $request->setUserResolver(function () use ($accessToken) {
                    return $accessToken->tokenable;
                });
            }
        }

        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Log::info('Faktur request for ID: ' . $id);

        $booking = Booking::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['mobil', 'user'])
            ->first();

        if (!$booking) {
            Log::warning('Booking not found or access denied for ID: ' . $id);
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan atau Anda tidak memiliki akses',
            ], 404);
        }

        try {
            $pdf = Pdf::loadView('faktur', compact('booking'));
            return $pdf->download('Faktur-' . $booking->kode_booking . '.pdf');
        } catch (\Exception $e) {
            Log::error('Faktur generation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat faktur: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan_customer' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $mobil = Mobil::find($request->mobil_id);

        if ($mobil->status !== 'tersedia') {
            return response()->json([
                'success' => false,
                'message' => 'Mobil tidak tersedia untuk disewa',
            ], 400);
        }

        // Cek apakah mobil sudah dibooking di tanggal tersebut
        $isBooked = Booking::where('mobil_id', $request->mobil_id)
            ->whereIn('status_booking', ['confirmed', 'checked_in'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                    });
            })
            ->exists();

        if ($isBooked) {
            return response()->json([
                'success' => false,
                'message' => 'Mobil sudah dibooking pada tanggal tersebut',
            ], 400);
        }

        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $durasiHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
        $totalHarga = $durasiHari * $mobil->harga_sewa_per_hari;

        $booking = Booking::create([
            'kode_booking' => Booking::generateKodeBooking(),
            'user_id' => $request->user()->id,
            'mobil_id' => $request->mobil_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi_hari' => $durasiHari,
            'harga_per_hari' => $mobil->harga_sewa_per_hari,
            'total_harga' => $totalHarga,
            'catatan_customer' => $request->catatan_customer,
            'status_pembayaran' => 'pending',
            'status_booking' => 'pending',
        ]);

        // Send WhatsApp Notification to Admin
        try {
            $admin = User::where('role', 'admin')->whereNotNull('nohp')->first();
            if ($admin) {
                $wa = new WhatsAppGateway();
                $customerName = $request->user()->name;
                $mobilName = $mobil->nama_mobil;
                $tglMulai = $tanggalMulai->format('d/m/Y');
                $tglSelesai = $tanggalSelesai->format('d/m/Y');
                $totalFormatted = 'Rp' . number_format($totalHarga, 0, ',', '.');

                $message = "📢 *Booking Baru!*\n\n"
                    . "Kode: *{$booking->kode_booking}*\n"
                    . "Customer: *{$customerName}*\n"
                    . "Mobil: *{$mobilName}*\n"
                    . "Durasi: *{$durasiHari} Hari*\n"
                    . "Jadwal: *{$tglMulai}* s/d *{$tglSelesai}*\n"
                    . "Total: *{$totalFormatted}*\n\n"
                    . "Silakan cek dashboard admin untuk verifikasi pembayaran.";

                $wa->sendText($admin->nohp, $message);
                Log::info("WhatsApp booking notification sent to admin: {$admin->nohp}");
            } else {
                Log::warning("WhatsApp notification skipped: No admin with phone number found.");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp booking notification: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat, silakan upload bukti pembayaran',
            'data' => $this->formatBookingData($booking),
        ], 201);
    }

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bukti_bayar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $booking = Booking::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan',
            ], 404);
        }

        if ($booking->status_pembayaran !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Bukti pembayaran sudah diupload',
            ], 400);
        }

        try {
            $file = $request->file('bukti_bayar');
            $filename = time() . '_bukti_' . $file->getClientOriginalName();

            $uploadPath = public_path('assets/images/bukti_bayar');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);

            $booking->update([
                'bukti_bayar' => $filename,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload, menunggu verifikasi admin',
                'data' => $this->formatBookingData($booking),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload bukti pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function myBookings(Request $request)
    {
        $bookings = Booking::where('user_id', $request->user()->id)
            ->with(['mobil'])
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $bookings->map(function ($booking) {
            return $this->formatBookingData($booking);
        });

        return response()->json([
            'success' => true,
            'message' => 'Data booking berhasil diambil',
            'data' => $data,
        ]);
    }

    public function show(Request $request, $id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with(['mobil'])
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail booking berhasil diambil',
            'data' => $this->formatBookingData($booking),
        ]);
    }

    private function formatBookingData($booking)
    {
        $booking->load(['mobil', 'user']);

        return [
            'id' => $booking->id,
            'kode_booking' => $booking->kode_booking,
            'mobil' => [
                'id' => $booking->mobil->id,
                'nama_mobil' => $booking->mobil->nama_mobil,
                'merk' => $booking->mobil->merk,
                'plat_nomor' => $booking->mobil->plat_nomor,
                'foto_mobil' => $booking->mobil->foto_mobil ? url('assets/images/mobil/' . $booking->mobil->foto_mobil) : null,
            ],
            'tanggal_mulai' => $booking->tanggal_mulai->format('Y-m-d'),
            'tanggal_selesai' => $booking->tanggal_selesai->format('Y-m-d'),
            'durasi_hari' => $booking->durasi_hari,
            'harga_per_hari' => (float) $booking->harga_per_hari,
            'total_harga' => (float) $booking->total_harga,
            'total_harga_formatted' => 'Rp.' . number_format($booking->total_harga, 0, ',', '.'),
            'bukti_bayar' => $booking->bukti_bayar ? url('assets/images/bukti_bayar/' . $booking->bukti_bayar) : null,
            'status_pembayaran' => $booking->status_pembayaran,
            'status_booking' => $booking->status_booking,
            'catatan_customer' => $booking->catatan_customer,
            'catatan_admin' => $booking->catatan_admin,
            'created_at' => $booking->created_at,
        ];
    }
}
