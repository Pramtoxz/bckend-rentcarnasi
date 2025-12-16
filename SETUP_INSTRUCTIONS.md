# Setup Instructions - Auth API dengan OTP WhatsApp

## 1. Update .env
Tambahkan konfigurasi WhatsApp Gateway ke file `.env`:
```env
WA_GATEWAY_URL=https://wa-gateway.myserverku.web.id
WA_GATEWAY_SECRET=OkYes!23*&!@%dsjPOETasdk
WA_SESSION_NAME=marketing
WA_GROUP_ID=120363421970612390@g.us
```

## 2. Jalankan Migration
```bash
php artisan migrate
```

## 3. Jalankan Seeder
```bash
php artisan db:seed
```

## 4. Buat Folder untuk Upload
Pastikan folder ini sudah ada:
```
public/assets/images/ktp/
public/assets/images/selfie/
```

## 5. Test API
Gunakan Postman atau tools lain untuk test endpoint di `API_DOCUMENTATION.md`

## Flow Aplikasi

### Customer (Mobile App):
1. User input nomor HP → Request OTP
2. User input kode OTP → Verify OTP
3. Jika user baru → Lengkapi data diri (nama, email, NIK, alamat, foto KTP, foto selfie)
4. Tunggu verifikasi admin
5. Setelah verified → Bisa rental mobil

### Admin (Web):
1. Login ke web admin
2. Buka menu "Verifikasi Customer"
3. Lihat list customer pending
4. Klik detail untuk lihat data lengkap dan foto
5. Terima atau tolak verifikasi
6. Customer akan dapat notifikasi status

## File Penting

**API Controllers:**
- `app/Http/Controllers/Api/AuthController.php` - Handle auth API

**Web Controllers:**
- `app/Http/Controllers/Web/CustomerVerificationController.php` - Handle verifikasi admin

**Services:**
- `app/Services/OTPService.php` - Generate & verify OTP
- `app/Services/WhatsAppGateway.php` - Kirim pesan WA

**Models:**
- `app/Models/User.php` - User model dengan field customer
- `app/Models/OTP.php` - OTP codes

**Routes:**
- `routes/api.php` - API routes
- `routes/web.php` - Web admin routes

**Migrations:**
- `database/migrations/2024_12_16_000001_add_customer_fields_to_users_table.php`
- `database/migrations/2024_12_16_000002_create_otp_codes_table.php`
- `database/migrations/2024_12_16_000003_create_config_wa_table.php`

**Views:**
- `resources/views/admin/customer-verification/index.blade.php`
- `resources/views/admin/customer-verification/show.blade.php`
