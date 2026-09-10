<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unmatched_photos', function (Blueprint $table) {
            $table->id();
            $table->string('nopol_detected')->nullable(); // Nopol yang terbaca dari nama file
            $table->string('slot_detected')->nullable();  // Slot foto (misal: _2, _3, _4)
            $table->string('file_name');                  // Nama file fisik foto
            $table->string('file_path');                  // Lokasi penyimpanan sementara/folder tujuan
            $table->text('reason');                       // Alasan masuk review (misal: Nopol tidak ditemukan / Urutan slot bolong)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unmatched_photos');
    }
};
