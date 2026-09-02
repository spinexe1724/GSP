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
      Schema::create('showrooms', function (Blueprint $table) {
    $table->id();
    $table->string('cno')->nullable();
    $table->string('kdcab');
    $table->string('inisial');
    $table->string('nmdealer');
    $table->string('cnm');
    $table->string('ad1');
    $table->string('ad2');
    $table->string('kota');
    $table->string('dlmou');
    $table->string('dlmoutglfr');
    $table->string('dlmoutglto');
    $table->text('alamat');
    $table->text('clprnoktp')->unique();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showrooms');
    }
};
