<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $booking->kode_booking }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            color: #666;
        }
        .details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 5px 0;
        }
        .items-table {
            margin-top: 20px;
        }
        .items-table th {
            background-color: #f9fafb;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        .total-box {
            display: inline-block;
            width: 250px;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            border-top: 1px solid #e5e7eb;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #f0f0f0;
            padding-top: 20px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .badge-verified { background-color: #dcfce7; color: #166534; }
        .badge-pending { background-color: #fef9c3; color: #854d0e; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">RentCarNasi</div>
            <div class="invoice-title">
                <h1>Faktur</h1>
                <div>{{ $booking->kode_booking }}</div>
                <div>{{ $booking->created_at->format('d F Y') }}</div>
            </div>
        </div>

        <div class="details">
            <table class="info-table">
                <tr>
                    <td style="width: 50%;">
                        <strong>Informasi Customer:</strong><br>
                        {{ $booking->user->name }}<br>
                        {{ $booking->user->email }}<br>
                        {{ $booking->user->phone ?? '-' }}
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Status Pembayaran:</strong><br>
                        <span class="badge {{ $booking->status_pembayaran === 'verified' ? 'badge-verified' : 'badge-pending' }}">
                            {{ strtoupper($booking->status_pembayaran) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Sewa</th>
                    <th>Durasi</th>
                    <th>Harga/Hari</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $booking->mobil->nama_mobil }}</strong><br>
                        <small>{{ $booking->mobil->merk }} - {{ $booking->mobil->plat_nomor }}</small><br>
                        <small>{{ $booking->tanggal_mulai->format('d/m/Y') }} sd {{ $booking->tanggal_selesai->format('d/m/Y') }}</small>
                    </td>
                    <td>{{ $booking->durasi_hari }} Hari</td>
                    <td>Rp {{ number_format($booking->harga_per_hari, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span>Total Harga</span>
                    <span>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah mempercayakan perjalanan Anda kepada RentCarNasi.</p>
            <p>&copy; {{ date('Y') }} RentCarNasi - Padang Panjang</p>
        </div>
    </div>
</body>
</html>
