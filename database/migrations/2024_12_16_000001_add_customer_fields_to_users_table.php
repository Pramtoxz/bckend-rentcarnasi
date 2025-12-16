<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nohp')->unique()->nullable()->after('email');
            $table->string('nik')->unique()->nullable()->after('nohp');
            $table->text('alamat')->nullable()->after('nik');
            $table->string('foto_ktp')->nullable()->after('alamat');
            $table->string('foto_selfie')->nullable()->after('foto_ktp');
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('foto_selfie');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending')->after('role');
            $table->text('catatan_verifikasi')->nullable()->after('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nohp', 'nik', 'alamat', 'foto_ktp', 'foto_selfie', 'role', 'status_verifikasi', 'catatan_verifikasi']);
        });
    }
};
