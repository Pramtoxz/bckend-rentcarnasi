<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mobil');
            $table->string('merk');
            $table->string('plat_nomor')->unique();
            $table->year('tahun');
            $table->string('warna');
            $table->enum('jenis_transmisi', ['manual', 'automatic']);
            $table->integer('kapasitas_penumpang');
            $table->decimal('harga_sewa_per_hari', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->string('foto_mobil')->nullable();
            $table->enum('status', ['tersedia', 'disewa', 'maintenance'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
