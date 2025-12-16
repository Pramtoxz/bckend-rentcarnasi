# API Documentation - Rental Mobil

Base URL: `http://localhost:8000/api`

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
      "status_verifikasi": "pending",
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

### 5. Logout
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
