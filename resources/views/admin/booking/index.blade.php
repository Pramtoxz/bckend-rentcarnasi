@extends('layouts.app')

@section('title', 'Data Booking')

@section('content')
<div class="row mb-3">
    <div class="col">
        <h2 class="page-title">Data Booking</h2>
        <div class="text-muted mt-1">Kelola dan verifikasi booking rental mobil</div>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Booking</h3>
            </div>
            <div class="card-body border-bottom py-3">
                <form method="GET" action="{{ route('booking.index') }}" class="row g-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari kode booking, customer, atau mobil..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                                Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status_pembayaran" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Pembayaran</option>
                            <option value="pending" {{ request('status_pembayaran') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status_pembayaran') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ request('status_pembayaran') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status_booking" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status_booking') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status_booking') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="checked_in" {{ request('status_booking') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                            <option value="completed" {{ request('status_booking') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status_booking') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    @if(request('search') || request('status_pembayaran') || request('status_booking'))
                    <div class="col-md-2">
                        <a href="{{ route('booking.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                    @endif
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Booking</th>
                            <th>Customer</th>
                            <th>Mobil</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th class="w-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                        <tr>
                            <td>{{ $bookings->firstItem() + $index }}</td>
                            <td><span class="badge bg-dark text-white">{{ $booking->kode_booking }}</span></td>
                            <td>
                                <div class="d-flex py-1 align-items-center">
                                    <span class="avatar me-2" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($booking->user->name) }})"></span>
                                    <div class="flex-fill">
                                        <div class="font-weight-medium">{{ $booking->user->name }}</div>
                                        <div class="text-muted"><small>{{ $booking->user->nohp }}</small></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $booking->mobil->nama_mobil }}</div>
                                <div class="text-muted"><small>{{ $booking->mobil->plat_nomor }}</small></div>
                            </td>
                            <td>
                                <div>{{ $booking->tanggal_mulai->format('d/m/Y') }}</div>
                                <div class="text-muted"><small>s/d {{ $booking->tanggal_selesai->format('d/m/Y') }}</small></div>
                                <div class="text-muted"><small>({{ $booking->durasi_hari }} hari)</small></div>
                            </td>
                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if($booking->status_pembayaran === 'pending')
                                    <span class="badge bg-warning text-white">Pending</span>
                                @elseif($booking->status_pembayaran === 'verified')
                                    <span class="badge bg-success text-white">Verified</span>
                                @else
                                    <span class="badge bg-danger text-white">Rejected</span>
                                @endif
                            </td>
                            <td>
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
                            </td>
                            <td>
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><line x1="3" y1="10" x2="21" y2="10" /><line x1="7" y1="15" x2="7.01" y2="15" /><line x1="11" y1="15" x2="13" y2="15" /></svg>
                                    </div>
                                    <p class="empty-title">Tidak ada data booking</p>
                                    <p class="empty-subtitle text-muted">
                                        @if(request('search') || request('status_pembayaran') || request('status_booking'))
                                            Tidak ada hasil yang sesuai dengan pencarian Anda
                                        @else
                                            Belum ada booking yang terdaftar
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bookings->hasPages())
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">
                    Menampilkan <span>{{ $bookings->firstItem() }}</span> sampai <span>{{ $bookings->lastItem() }}</span> dari <span>{{ $bookings->total() }}</span> data
                </p>
                <ul class="pagination m-0 ms-auto">
                    {{ $bookings->appends(request()->query())->links() }}
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
