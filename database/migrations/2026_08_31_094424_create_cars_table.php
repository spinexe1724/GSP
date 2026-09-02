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
            $table->string('nopol')->nullable()->index();
            $table->string('merk')->nullable();
            $table->string('type')->nullable();
            $table->string('tahun')->nullable();
            
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