<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('showroom_id')->nullable()->after('password');
        $table->string('role')->default('showroom')->after('showroom_id');
        
        // Asumsi primary key di tabel showrooms adalah 'id'
        $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
