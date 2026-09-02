<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi: Mobil dimiliki oleh Showroom
     * Foreign Key di Car: cif_dealer
     * Owner Key di Showroom: cno
     */
    public function showroom()
    {
        return $this->belongsTo(Showroom::class, 'cif_konsumen', 'cno');
    }
}