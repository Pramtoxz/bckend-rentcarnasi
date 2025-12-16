<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function requestOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nohp' => 'required|string|regex:/^[0-9]{10,15}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $nohp = $request->nohp;
        
        $existingUser = User::where('nohp', $nohp)->first();
        $type = $existingUser ? 'login' : 'register';

        try {
            $otpCode = $this->otpService->generateOTP($nohp, $type);
            $this->otpService->sendOTP($nohp, $otpCode);

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim ke WhatsApp',
                'data' => [
                    'nohp' => $nohp,
                    'type' => $type
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nohp' => 'required|string',
            'otp_code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!$this->otpService->verifyOTP($request->nohp, $request->otp_code)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP tidak valid atau sudah kadaluarsa'
            ], 401);
        }

        $user = User::where('nohp', $request->nohp)->first();

        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'needs_profile' => !$user->nik
                ]
            ]);
        }

        // User baru - buat temporary user untuk dapat token
        $tempUser = User::create([
            'nohp' => $request->nohp,
            'name' => 'Temporary',
            'email' => $request->nohp . '@temp.com',
            'password' => Hash::make($request->nohp),
            'role' => 'customer',
            'status_verifikasi' => 'pending',
        ]);

        $token = $tempUser->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'OTP terverifikasi, silakan lengkapi data diri',
            'data' => [
                'token' => $token,
                'needs_profile' => true
            ]
        ]);
    }

    public function completeProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|string|size:16|unique:users,nik',
            'alamat' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'foto_selfie' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Upload foto KTP
            $fileKtp = $request->file('foto_ktp');
            $filenameKtp = time() . '_ktp_' . $fileKtp->getClientOriginalName();
            $fileKtp->move(public_path('assets/images/ktp'), $filenameKtp);

            // Upload foto Selfie
            $fileSelfie = $request->file('foto_selfie');
            $filenameSelfie = time() . '_selfie_' . $fileSelfie->getClientOriginalName();
            $fileSelfie->move(public_path('assets/images/selfie'), $filenameSelfie);

            // Update user yang sudah ada
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'foto_ktp' => $filenameKtp,
                'foto_selfie' => $filenameSelfie,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil, menunggu verifikasi admin',
                'data' => [
                    'user' => $user->fresh()
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
