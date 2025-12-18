@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="row mb-3">
    <div class="col">
        <h2 class="page-title">Detail Booking</h2>
        <div class="text-muted mt-1">{{ $booking->kode_booking }}</div>
    </div>
    <div class="col-auto ms-auto">
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="5" y1="12" x2="19" y2="12" /><line x1="5" y1="12" x2="9" y2="16" /><line x1="5" y1="12" x2="9" y2="8" /></svg>
            Kembali
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <div class="d-flex">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
        </div>
        <div>{{ session('success') }}</div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <div class="d-flex">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
        </div>
        <div>{{ session('error') }}</div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Informasi Booking</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Booking</label>
                        <div><strong>{{ $booking->kode_booking }}</strong></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Booking</label>
                        <div>{{ $booking->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Status Pembayaran</label>
                        <div>
                            @if($booking->status_pembayaran === 'pending')
                                <span class="badge bg-warning text-white">Pending</span>
                            @elseif($booking->status_pembayaran === 'verified')
                                <span class="badge bg-success text-white">Verified</span>
                            @else
                                <span class="badge bg-danger text-white">Rejected</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Booking</label>
                        <div>
                            @if($booking->status_booking === 'pending')
                                <span class="badge bg-secondary text-white">Pending</span>
                            @elseif($booking->status_booking === 'confirmed')
                                <span class="badge bg-info text-white">Confirmed</span>
                            @elseif($booking->status_booking === 'checked_in')
                                <span class="badge bg-primary text-white">Checked In</span>
                            @elseif($booking->status_booking === 'completed')
                                <span class="badge bg-success text-white">Completed</span>
                            @else
                                <span class="badge bg-danger text-white">Cancelled</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Data Customer</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <div>{{ $booking->user->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP</label>
                        <div>{{ $booking->user->nohp }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <div>{{ $booking->user->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <div>{{ $booking->user->nik }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Data Mobil</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($booking->mobil->foto_mobil)
                        <img src="{{ asset('assets/images/mobil/' . $booking->mobil->foto_mobil) }}" class="img-fluid rounded" alt="{{ $booking->mobil->nama_mobil }}">
                        @else
                        <div class="bg-light rounded p-4 text-center">No Image</div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="mb-2">
                            <label class="form-label">Nama Mobil</label>
                            <div><strong>{{ $booking->mobil->nama_mobil }}</strong></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Merk</label>
                            <div>{{ $booking->mobil->merk }}</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Plat Nomor</label>
                            <div><span class="badge bg-dark">{{ $booking->mobil->plat_nomor }}</span></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Transmisi</label>
                            <div>{{ ucfirst($booking->mobil->jenis_transmisi) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Rental</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Mulai</label>
                        <div>{{ $booking->tanggal_mulai->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Selesai</label>
                        <div>{{ $booking->tanggal_selesai->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Durasi</label>
                        <div>{{ $booking->durasi_hari }} Hari</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga per Hari</label>
                        <div>Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Total Harga</label>
                        <div><strong class="text-primary fs-3">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></div>
                    </div>
                </div>
                @if($booking->catatan_customer)
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Catatan Customer</label>
                        <div class="alert alert-info">{{ $booking->catatan_customer }}</div>
                    </div>
                </div>
                @endif
                @if($booking->catatan_admin)
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Catatan Admin</label>
                        <div class="alert alert-warning">{{ $booking->catatan_admin }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if($booking->bukti_bayar)
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Bukti Pembayaran</h3>
            </div>
            <div class="card-body">
                <img src="{{ asset('assets/images/bukti_bayar/' . $booking->bukti_bayar) }}" class="img-fluid rounded" alt="Bukti Pembayaran">
            </div>
        </div>
        @endif

        @if($booking->status_pembayaran === 'pending' && $booking->bukti_bayar)
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Verifikasi Pembayaran</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('booking.verify-payment', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Opsional"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="verified" class="btn btn-success" onclick="return confirm('Verifikasi pembayaran ini?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            Verifikasi
                        </button>
                        <button type="submit" name="status" value="rejected" class="btn btn-danger" onclick="return confirm('Tolak pembayaran ini?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if($booking->status_booking === 'confirmed')
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Check-In Customer</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Customer sudah bisa mengambil mobil</p>
                <form action="{{ route('booking.check-in', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Konfirmasi check-in customer?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                        Check-In
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($booking->status_booking === 'checked_in')
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Selesaikan Rental</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Mobil sudah dikembalikan customer</p>
                <form action="{{ route('booking.complete', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Selesaikan rental ini?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                        Selesai
                    </button>
                </form>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Timeline</h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <div class="text-muted small">{{ $booking->created_at->format('d/m/Y H:i') }}</div>
                        <div>Booking dibuat</div>
                    </li>
                    @if($booking->verified_at)
                    <li class="mb-2">
                        <div class="text-muted small">{{ $booking->verified_at->format('d/m/Y H:i') }}</div>
                        <div>Pembayaran diverifikasi</div>
                    </li>
                    @endif
                    @if($booking->checked_in_at)
                    <li class="mb-2">
                        <div class="text-muted small">{{ $booking->checked_in_at->format('d/m/Y H:i') }}</div>
                        <div>Customer check-in</div>
                    </li>
                    @endif
                    @if($booking->completed_at)
                    <li>
                        <div class="text-muted small">{{ $booking->completed_at->format('d/m/Y H:i') }}</div>
                        <div>Rental selesai</div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
