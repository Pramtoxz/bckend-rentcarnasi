<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_mobil', 'ILIKE', "%{$search}%")
                  ->orWhere('merk', 'ILIKE', "%{$search}%")
                  ->orWhere('plat_nomor', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $mobils = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.mobil.index', compact('mobils'));
    }

    public function create()
    {
        return view('admin.mobil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'plat_nomor' => 'required|string|unique:mobils,plat_nomor',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'jenis_transmisi' => 'required|in:manual,automatic',
            'kapasitas_penumpang' => 'required|integer|min:1|max:20',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto_mobil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:tersedia,disewa,maintenance',
        ]);

        try {
            $data = $request->except('foto_mobil');

            if ($request->hasFile('foto_mobil')) {
                $file = $request->file('foto_mobil');
                $filename = time() . '_mobil_' . $file->getClientOriginalName();
                
                $uploadPath = public_path('assets/images/mobil');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $filename);
                $data['foto_mobil'] = $filename;
            }

            Mobil::create($data);

            return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('admin.mobil.show', compact('mobil'));
    }

    public function edit(string $id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('admin.mobil.edit', compact('mobil'));
    }

    public function update(Request $request, string $id)
    {
        $mobil = Mobil::findOrFail($id);

        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'plat_nomor' => 'required|string|unique:mobils,plat_nomor,' . $id,
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'jenis_transmisi' => 'required|in:manual,automatic',
            'kapasitas_penumpang' => 'required|integer|min:1|max:20',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto_mobil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status' => 'required|in:tersedia,disewa,maintenance',
        ]);

        try {
            $data = $request->except('foto_mobil');

            if ($request->hasFile('foto_mobil')) {
                $uploadPath = public_path('assets/images/mobil');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                if ($mobil->foto_mobil && file_exists($uploadPath . '/' . $mobil->foto_mobil)) {
                    unlink($uploadPath . '/' . $mobil->foto_mobil);
                }

                $file = $request->file('foto_mobil');
                $filename = time() . '_mobil_' . $file->getClientOriginalName();
                $file->move($uploadPath, $filename);
                $data['foto_mobil'] = $filename;
            }

            $mobil->update($data);

            return redirect()->route('mobil.index')->with('success', 'Mobil berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $mobil = Mobil::findOrFail($id);

            $uploadPath = public_path('assets/images/mobil');
            if ($mobil->foto_mobil && file_exists($uploadPath . '/' . $mobil->foto_mobil)) {
                unlink($uploadPath . '/' . $mobil->foto_mobil);
            }

            $mobil->delete();

            return redirect()->route('mobil.index')->with('success', 'Mobil berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
