# API Documentation - Rental Mobil

Base URL: `https://rentcarnasi.ngalauminangmaimbau.web.id/api`

## Authentication Flow

### 1. Request OTP
**Endpoint:** `POST /auth/request-otp`

**Request Body:**
```json
{
  "nohp": "628123456789"
}
```

**Response Success:**
```json
{
  "success": true,
  "message": "Kode OTP berhasil dikirim ke WhatsApp",
  "data": {
    "nohp": "628123456789",
    "type": "register"
  }
}
```

### 2. Verify OTP
**Endpoint:** `POST /auth/verify-otp`

**Request Body:**
```json
{
  "nohp": "628123456789",
  "otp_code": "123456"
}
```

**Response (User Baru):**
```json
{
  "success": true,
  "message": "OTP terverifikasi, silakan lengkapi data diri",
  "data": {
    "token": "1|xxxxx",
    "needs_profile": true
  }
}
```

**Response (User Existing):**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {...},
    "token": "1|xxxxx",
    "needs_profile": false
  }
}
```

### 3. Complete Profile (User Baru)
**Endpoint:** `POST /auth/complete-profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body (multipart/form-data):**
```
name: John Doe
email: john@example.com
nik: 1234567890123456
alamat: Jl. Example No. 123
foto_ktp: [file]
foto_selfie: [file]
```

**Response:**
```json
{
  "success": true,
  "message": "Registrasi berhasil, menunggu verifikasi admin",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "nohp": "628123456789",
      "nik": "1234567890123456",
      "status_verifikasi": "pending" atau "rejected" atau "verified",
      "role": "customer"
    }
  }
}
```
```

### 4. Get Profile
**Endpoint:** `GET /profile`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "nohp": "628123456789",
    "status_verifikasi": "verified"
  }
}
```

### 5. Update Profile
**Endpoint:** `POST /profile/update`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body (multipart/form-data):**
```
name: John Doe (optional)
email: john@example.com (optional)
nik: 1234567890123456 (optional)
alamat: Jl. Example No. 123 (optional)
foto_ktp: [file] (optional)
foto_selfie: [file] (optional)
```

**Response:**
```json
{
  "success": true,
  "message": "Profile berhasil diupdate",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "nohp": "628123456789",
      "nik": "1234567890123456",
      "alamat": "Jl. Example No. 123",
      "foto_ktp": "1734567890_ktp_example.jpg",
      "foto_selfie": "1734567890_selfie_example.jpg",
      "status_verifikasi": "verified",
      "role": "customer"
    }
  }
}
```

**Notes:**
- Semua field bersifat optional, hanya kirim field yang ingin diupdate
- Jika upload foto baru, foto lama akan otomatis dihapus
- Email dan NIK harus unique (tidak boleh sama dengan user lain)

### 6. Logout
**Endpoint:** `POST /logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

## Status Verifikasi
- `pending`: Menunggu verifikasi admin
- `verified`: Sudah diverifikasi, bisa rental mobil
- `rejected`: Ditolak admin

## Error Responses

**Validation Error (422):**
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "nohp": ["The nohp field is required."]
  }
}
```

**Unauthorized (401):**
```json
{
  "success": false,
  "message": "Kode OTP tidak valid atau sudah kadaluarsa"
}
```

**Forbidden (403):**
```json
{
  "success": false,
  "message": "Akun Anda masih menunggu verifikasi admin",
  "data": {
    "status_verifikasi": "pending"
  }
}
```
## Mobil Endpoints

### 1. Get All Mobil
**Endpoint:** `GET /mobil`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `merk` - Filter berdasarkan merk (contoh: `?merk=toyota`)
- `transmisi` - Filter berdasarkan transmisi (`manual` atau `automatic`)
- `status` - Filter berdasarkan status (`tersedia`, `disewa`, atau `maintenance`)
- `search` - Pencarian nama mobil, merk, atau plat nomor
- Bisa kombinasi: `?merk=toyota&transmisi=manual&status=tersedia`

**Response:**
```json
{
  "success": true,
  "message": "Data mobil berhasil diambil",
  "data": [
    {
      "id": 1,
      "nama_mobil": "Lamborghini Urus",
      "merk": "Lamborghini",
      "plat_nomor": "BA 1234 AS",
      "tahun": 2022,
      "warna": "Yellow",
      "jenis_transmisi": "automatic",
      "kapasitas_penumpang": 4,
      "harga_sewa_per_hari": 500000,
      "harga_formatted": "Rp.500.000/Day",
      "deskripsi": "SUV Car, Off Road",
      "foto_mobil": "http://localhost:8000/assets/images/mobil/1765955237_mobil_lamborghini.png",
      "status": "tersedia",
      "created_at": "2025-12-17T14:07:17.000000Z",
      "updated_at": "2025-12-17T14:07:17.000000Z"
    }
  ]
}
```

### 2. Get Mobil Detail
**Endpoint:** `GET /mobil/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Detail mobil berhasil diambil",
  "data": {
    "id": 1,
    "nama_mobil": "Lamborghini Urus",
    "merk": "Lamborghini",
    "plat_nomor": "BA 1234 AS",
    "tahun": 2022,
    "warna": "Yellow",
    "jenis_transmisi": "automatic",
    "kapasitas_penumpang": 4,
    "harga_sewa_per_hari": 500000,
    "harga_formatted": "Rp.500.000/Day",
    "deskripsi": "SUV Car, Off Road",
    "foto_mobil": "http://localhost:8000/assets/images/mobil/1765955237_mobil_lamborghini.png",
    "status": "tersedia",
    "created_at": "2025-12-17T14:07:17.000000Z",
    "updated_at": "2025-12-17T14:07:17.000000Z"
  }
}
```

### 3. Get Rekomendasi Mobil
**Endpoint:** `GET /mobil/rekomendasi`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Data rekomendasi mobil berhasil diambil",
  "data": [
    {
      "id": 1,
      "nama_mobil": "Lamborghini Urus",
      "merk": "Lamborghini",
      "harga_sewa_per_hari": 500000,
      "harga_formatted": "Rp.500.000/Day",
      "foto_mobil": "http://localhost:8000/assets/images/mobil/1765955237_mobil_lamborghini.png",
      "status": "tersedia"
    }
  ]
}
```

## Booking Endpoints

### 1. Create Booking
**Endpoint:** `POST /booking`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "mobil_id": 1,
  "tanggal_mulai": "2025-12-20",
  "tanggal_selesai": "2025-12-22",
  "catatan_customer": "Mohon mobil dalam kondisi bersih"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Booking berhasil dibuat, silakan upload bukti pembayaran",
  "data": {
    "id": 1,
    "kode_booking": "BK202512180001",
    "mobil": {
      "id": 1,
      "nama_mobil": "Lamborghini Urus",
      "merk": "Lamborghini",
      "plat_nomor": "BA 1234 AS",
      "foto_mobil": "http://localhost:8000/assets/images/mobil/..."
    },
    "tanggal_mulai": "2025-12-20",
    "tanggal_selesai": "2025-12-22",
    "durasi_hari": 3,
    "harga_per_hari": 500000,
    "total_harga": 1500000,
    "total_harga_formatted": "Rp.1.500.000",
    "bukti_bayar": null,
    "status_pembayaran": "pending",
    "status_booking": "pending",
    "catatan_customer": "Mohon mobil dalam kondisi bersih",
    "catatan_admin": null
  }
}
```

### 2. Upload Bukti Pembayaran
**Endpoint:** `POST /booking/{id}/upload-bukti`

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body (multipart/form-data):**
```
bukti_bayar: [file]
```

**Response:**
```json
{
  "success": true,
  "message": "Bukti pembayaran berhasil diupload, menunggu verifikasi admin",
  "data": {
    "id": 1,
    "kode_booking": "BK202512180001",
    "bukti_bayar": "http://localhost:8000/assets/images/bukti_bayar/...",
    "status_pembayaran": "pending",
    "status_booking": "pending"
  }
}
```

### 3. Get My Bookings
**Endpoint:** `GET /booking`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Data booking berhasil diambil",
  "data": [
    {
      "id": 1,
      "kode_booking": "BK202512180001",
      "mobil": {...},
      "tanggal_mulai": "2025-12-20",
      "tanggal_selesai": "2025-12-22",
      "durasi_hari": 3,
      "total_harga": 1500000,
      "total_harga_formatted": "Rp.1.500.000",
      "status_pembayaran": "verified",
      "status_booking": "confirmed"
    }
  ]
}
```

### 4. Get Booking Detail
**Endpoint:** `GET /booking/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Detail booking berhasil diambil",
  "data": {
    "id": 1,
    "kode_booking": "BK202512180001",
    "mobil": {...},
    "tanggal_mulai": "2025-12-20",
    "tanggal_selesai": "2025-12-22",
    "durasi_hari": 3,
    "total_harga": 1500000,
    "status_pembayaran": "verified",
    "status_booking": "confirmed"
  }
}
```

## Booking Status Flow

### Status Pembayaran:
- `pending` - Menunggu upload bukti pembayaran
- `verified` - Pembayaran sudah diverifikasi admin
- `rejected` - Pembayaran ditolak admin

### Status Booking:
- `pending` - Menunggu verifikasi pembayaran
- `confirmed` - Pembayaran terverifikasi, menunggu hari H
- `checked_in` - Customer sudah mengambil mobil
- `completed` - Rental selesai, mobil sudah dikembalikan
- `cancelled` - Booking dibatalkan
