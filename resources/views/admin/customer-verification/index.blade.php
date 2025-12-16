@extends('layouts.app')

@section('title', 'Verifikasi Customer')

@section('content')
<div class="row mb-3">
    <div class="col">
        <h2 class="page-title">Verifikasi Customer</h2>
        <div class="text-muted mt-1">Kelola verifikasi data customer</div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Email</th>
                                <th>NIK</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->nohp }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->nik }}</td>
                                <td>
                                    @if($customer->status_verifikasi === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($customer->status_verifikasi === 'verified')
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('customer-verification.show', $customer->id) }}" class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data customer</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
