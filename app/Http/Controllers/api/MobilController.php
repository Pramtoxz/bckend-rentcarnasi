<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::query();

        // Filter berdasarkan merk
        if ($request->has('merk') && $request->merk != '') {
            $query->where('merk', 'ILIKE', '%' . $request->merk . '%');
        }

        // Filter berdasarkan transmisi
        if ($request->has('transmisi') && $request->transmisi != '') {
            $query->where('jenis_transmisi', $request->transmisi);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mobil', 'ILIKE', "%{$search}%")
                    ->orWhere('merk', 'ILIKE', "%{$search}%")
                    ->orWhere('plat_nomor', 'ILIKE', "%{$search}%");
            });
        }

        $mobils = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Data mobil berhasil diambil',
            'data' => $mobils->items(),
            'pagination' => [
                'current_page' => $mobils->currentPage(),
                'last_page' => $mobils->lastPage(),
                'per_page' => $mobils->perPage(),
                'total' => $mobils->total(),
            ],
        ]);
    }

    public function show($id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json([
                'success' => false,
                'message' => 'Mobil tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail mobil berhasil diambil',
            'data' => $mobil,
        ]);
    }
}
