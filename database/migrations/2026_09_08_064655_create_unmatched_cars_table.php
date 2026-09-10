<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unmatched_cars', function (Blueprint $table) {
            $table->id();
            $table->string('no_polisi')->unique();
            $table->string('no_cif')->nullable();
            $table->string('nama_merk')->nullable();
            $table->string('tipe_kend')->nullable();
            $table->string('warna_kend')->nullable();
            $table->string('jenis_kend')->nullable();
            $table->string('transmisi')->nullable();
            $table->string('tahun_buat')->nullable();
            $table->string('foto_depan')->nullable();
            $table->string('foto_belakang')->nullable();
            $table->string('foto_samping')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unmatched_cars');
    }
};