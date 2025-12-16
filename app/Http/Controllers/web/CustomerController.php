<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhere('nohp', 'ILIKE', "%{$search}%")
                  ->orWhere('nik', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_verifikasi', $request->status);
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.customer.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        return view('admin.customer.show', compact('customer'));
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

        return redirect()->route('customer.index')
            ->with('success', $message);
    }
}
