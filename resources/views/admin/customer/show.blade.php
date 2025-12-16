@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="row mb-3">
    <div class="col">
        <h2 class="page-title">Detail Customer</h2>
        <div class="text-muted mt-1">Informasi lengkap customer</div>
    </div>
    <div class="col-auto">
        <a href="{{ route('customer.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Customer</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="mb-3">Data Diri</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150">Nama</td>
                                    <td>: {{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td>: {{ $customer->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ $customer->email }}</td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>: {{ $customer->nik }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{ $customer->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>: 
                                        @if($customer->status_verifikasi === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($customer->status_verifikasi === 'verified')
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    
                    <div class="col-md-6">
                        <h5 class="mb-3">Dokumen</h5>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto KTP:</label><br>
                            <img src="{{ asset('assets/images/ktp/' . $customer->foto_ktp) }}" alt="KTP" class="img-fluid rounded border" style="max-height: 300px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Selfie:</label><br>
                            <img src="{{ asset('assets/images/selfie/' . $customer->foto_selfie) }}" alt="Selfie" class="img-fluid rounded border" style="max-height: 300px;">
                        </div>
                    </div>
                </div>

                @if($customer->catatan_verifikasi)
                <div class="alert alert-info">
                    <strong>Catatan:</strong> {{ $customer->catatan_verifikasi }}
                </div>
                @endif

                @if($customer->status_verifikasi === 'pending')
                <hr>
                <h5 class="mb-3">Verifikasi Customer</h5>
                <form action="{{ route('customer.verify', $customer->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select name="status" class="form-select" required>
                            <option value="">Pilih Status</option>
                            <option value="verified">✓ Terima</option>
                            <option value="rejected">✗ Tolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-2"></i>Simpan Verifikasi
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
