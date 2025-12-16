@extends('layouts.app') 

@section('title', 'Dashboard Admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dashboard</h3>
    </div>
    <div class="card-body">
        <h1>Selamat datang, {{ Auth::user()->name }}</h1>
        <p>Sistem Rental Mobil</p>
        
        <div class="mt-3">
            <a href="{{ route('customer-verification.index') }}" class="btn btn-primary">
                Lihat Customer
            </a>
        </div>
    </div>
</div>
@endsection