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
    Schema::table('cars', function (Blueprint $table) {
        $table->string('foto_depan')->nullable()->after('tahun');
        $table->string('foto_samping')->nullable()->after('foto_depan');
        $table->string('foto_belakang')->nullable()->after('foto_samping');
    });
}

public function down(): void
{
    Schema::table('cars', function (Blueprint $table) {
        $table->dropColumn(['foto_depan', 'foto_samping', 'foto_belakang']);
    });
}
};
