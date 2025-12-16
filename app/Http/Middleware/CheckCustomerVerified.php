<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCustomerVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->role === 'customer' && $user->status_verifikasi !== 'verified') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda masih menunggu verifikasi admin',
                'data' => [
                    'status_verifikasi' => $user->status_verifikasi
                ]
            ], 403);
        }

        return $next($request);
    }
}
