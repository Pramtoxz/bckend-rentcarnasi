@extends('layouts.app')

@section('title', 'Tambah Mobil')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Tambah Mobil</h2>
                <div class="text-muted mt-1">Tambahkan mobil baru ke sistem</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('mobil.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Mobil</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Nama Mobil</label>
                                    <input type="text" name="nama_mobil" class="form-control @error('nama_mobil') is-invalid @enderror" value="{{ old('nama_mobil') }}" placeholder="Contoh: Toyota Avanza">
                                    @error('nama_mobil')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Merk</label>
                                    <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" value="{{ old('merk') }}" placeholder="Contoh: Toyota">
                                    @error('merk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Plat Nomor</label>
                                    <input type="text" name="plat_nomor" class="form-control @error('plat_nomor') is-invalid @enderror" value="{{ old('plat_nomor') }}" placeholder="Contoh: B 1234 XYZ">
                                    @error('plat_nomor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Tahun</label>
                                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}" placeholder="Contoh: 2023">
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Warna</label>
                                    <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror" value="{{ old('warna') }}" placeholder="Contoh: Hitam">
                                    @error('warna')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Jenis Transmisi</label>
                                    <select name="jenis_transmisi" class="form-select @error('jenis_transmisi') is-invalid @enderror">
                                        <option value="">Pilih Transmisi</option>
                                        <option value="manual" {{ old('jenis_transmisi') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ old('jenis_transmisi') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    </select>
                                    @error('jenis_transmisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Kapasitas Penumpang</label>
                                    <input type="number" name="kapasitas_penumpang" class="form-control @error('kapasitas_penumpang') is-invalid @enderror" value="{{ old('kapasitas_penumpang') }}" placeholder="Contoh: 7">
                                    @error('kapasitas_penumpang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label required">Harga Sewa/Hari (Rp)</label>
                                    <input type="number" name="harga_sewa_per_hari" class="form-control @error('harga_sewa_per_hari') is-invalid @enderror" value="{{ old('harga_sewa_per_hari') }}" placeholder="Contoh: 300000">
                                    @error('harga_sewa_per_hari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="">Pilih Status</option>
                                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Foto Mobil</label>
                                    <input type="file" name="foto_mobil" class="form-control @error('foto_mobil') is-invalid @enderror" accept="image/*">
                                    @error('foto_mobil')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-hint">Format: JPG, JPEG, PNG. Max: 2MB</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi mobil...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('mobil.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
