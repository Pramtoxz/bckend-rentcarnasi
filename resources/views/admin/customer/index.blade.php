@extends('layouts.app')

@section('title', 'Verifikasi Customer')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Data Customers</h2>
                <div class="text-muted mt-1">Kelola dan verifikasi data customers</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Customer</h3>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <form method="GET" action="{{ route('customer.index') }}" class="row g-2">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, no HP, atau NIK..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                                        Cari
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            @if(request('search') || request('status'))
                            <div class="col-md-2">
                                <a href="{{ route('customer.index') }}" class="btn btn-secondary w-100">Reset</a>
                            </div>
                            @endif
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Email</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $index => $customer)
                                <tr>
                                    <td>{{ $customers->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2" style="background-image: url({{ $customer->foto_selfie ? asset('assets/images/selfie/' . $customer->foto_selfie) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) }})"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{ $customer->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $customer->nohp ?? '-' }}</td>
                                    <td class="text-muted">{{ $customer->email ?? '-' }}</td>
                                    <td class="text-muted">{{ $customer->nik ?? '-' }}</td>
                                    <td>
                                        @if($customer->status_verifikasi === 'pending')
                                            <span class="badge bg-warning text-white">Pending</span>
                                        @elseif($customer->status_verifikasi === 'verified')
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-muted">{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-sm btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                            </div>
                                            <p class="empty-title">Tidak ada data customer</p>
                                            <p class="empty-subtitle text-muted">
                                                @if(request('search') || request('status'))
                                                    Tidak ada hasil yang sesuai dengan pencarian Anda
                                                @else
                                                    Belum ada customer yang terdaftar
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($customers->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-muted">
                            Menampilkan <span>{{ $customers->firstItem() }}</span> sampai <span>{{ $customers->lastItem() }}</span> dari <span>{{ $customers->total() }}</span> data
                        </p>
                        <ul class="pagination m-0 ms-auto">
                            {{ $customers->appends(request()->query())->links() }}
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
