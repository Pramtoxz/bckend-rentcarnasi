@extends('layouts.app')

@section('title', 'Detail Mobil')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Detail Mobil</h2>
                <div class="text-muted mt-1">Informasi lengkap mobil</div>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('mobil.edit', $mobil->id) }}" class="btn btn-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                    Edit
                </a>
                <a href="{{ route('mobil.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($mobil->foto_mobil)
                            <img src="{{ asset('assets/images/mobil/' . $mobil->foto_mobil) }}" alt="{{ $mobil->nama_mobil }}" class="img-fluid rounded">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No Image" class="img-fluid rounded">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Mobil</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Mobil</label>
                                <p>{{ $mobil->nama_mobil }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Merk</label>
                                <p>{{ $mobil->merk }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Plat Nomor</label>
                                <p><span class="badge bg-dark">{{ $mobil->plat_nomor }}</span></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tahun</label>
                                <p>{{ $mobil->tahun }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Warna</label>
                                <p>{{ $mobil->warna }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Transmisi</label>
                                <p>{{ ucfirst($mobil->jenis_transmisi) }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kapasitas</label>
                                <p>{{ $mobil->kapasitas_penumpang }} Penumpang</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Status</label>
                                <p>
                                    @if($mobil->status === 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($mobil->status === 'disewa')
                                        <span class="badge bg-warning">Disewa</span>
                                    @else
                                        <span class="badge bg-danger">Maintenance</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Harga Sewa per Hari</label>
                                <p class="fs-3 text-primary">Rp {{ number_format($mobil->harga_sewa_per_hari, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @if($mobil->deskripsi)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <p>{{ $mobil->deskripsi }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Dibuat</label>
                                <p>{{ $mobil->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Terakhir Update</label>
                                <p>{{ $mobil->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
