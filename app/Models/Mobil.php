<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $fillable = [
        'nama_mobil',
        'merk',
        'plat_nomor',
        'tahun',
        'warna',
        'jenis_transmisi',
        'kapasitas_penumpang',
        'harga_sewa_per_hari',
        'deskripsi',
        'foto_mobil',
        'status',
    ];
}
