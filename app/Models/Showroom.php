<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    protected $fillable = [
        'cno','kdcab', 'inisial', 'nmdealer','cnm','ad1', 'ad2','kota', 
        'dlmou', 'dlmoutglfr', 'dlmoutglto', 'alamat', 'clprnoktp',
    ];
use HasFactory;

    protected $guarded = ['id'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'no_cif', 'cno');
    }
}


