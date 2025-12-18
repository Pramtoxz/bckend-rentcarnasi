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

        $mobils = $query->orderBy('created_at', 'desc')->get();

        $data = $mobils->map(function ($mobil) {
            return $this->formatMobilData($mobil);
        });

        return response()->json([
            'success' => true,
            'message' => 'Data mobil berhasil diambil',
            'data' => $data,
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
            'data' => $this->formatMobilData($mobil),
        ]);
    }

    public function rekomendasi()
    {
        $mobils = Mobil::where('status', 'tersedia')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $data = $mobils->map(function ($mobil) {
            return $this->formatMobilData($mobil);
        });

        return response()->json([
            'success' => true,
            'message' => 'Data rekomendasi mobil berhasil diambil',
            'data' => $data,
        ]);
    }

    private function formatMobilData($mobil)
    {
        return [
            'id' => $mobil->id,
            'nama_mobil' => $mobil->nama_mobil,
            'merk' => $mobil->merk,
            'plat_nomor' => $mobil->plat_nomor,
            'tahun' => $mobil->tahun,
            'warna' => $mobil->warna,
            'jenis_transmisi' => $mobil->jenis_transmisi,
            'kapasitas_penumpang' => $mobil->kapasitas_penumpang,
            'harga_sewa_per_hari' => (float) $mobil->harga_sewa_per_hari,
            'harga_formatted' => 'Rp.' . number_format($mobil->harga_sewa_per_hari, 0, ',', '.') . '/Day',
            'deskripsi' => $mobil->deskripsi,
            'foto_mobil' => $mobil->foto_mobil ? url('assets/images/mobil/' . $mobil->foto_mobil) : null,
            'status' => $mobil->status,
            'created_at' => $mobil->created_at,
            'updated_at' => $mobil->updated_at,
        ];
    }
}
