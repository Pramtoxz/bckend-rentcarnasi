<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerVerificationController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.customer-verification.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        return view('admin.customer-verification.show', compact('customer'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string',
        ]);

        $customer = User::where('role', 'customer')->findOrFail($id);
        
        $customer->update([
            'status_verifikasi' => $request->status,
            'catatan_verifikasi' => $request->catatan,
        ]);

        $message = $request->status === 'verified' 
            ? 'Customer berhasil diverifikasi' 
            : 'Customer ditolak';

        return redirect()->route('customer-verification.index')
            ->with('success', $message);
    }
}
