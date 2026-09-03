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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            
            // Kolom penghubung relasi ke showrooms.cno
            $table->string('no_cif')->index(); 
            
            // Kolom data spesifik mobil dari Excel
            $table->string('no_polisi')->nullable()->index();
            $table->string('jenis_kend')->nullable();
            $table->string('nama_merk')->nullable();
            $table->string('tipe_kend')->nullable();
            $table->string('transmisi')->nullable();
            $table->string('warna_kend')->nullable();
            $table->string('tahun_buat')->nullable();
            $table->string('foto_depan')->nullable();
            $table->string('foto_samping')->nullable();
            $table->string('foto_belakang')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};