<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <-- Diubah kembali menjadi Model biasa

class Showroom extends Model
{
    use HasFactory;

    protected $table = 'showrooms';
    protected $guarded = ['id'];

    // Menghapus 'extends Authenticatable', 'Notifiable', dan '$hidden = password' 
    // karena urusan login dan password sekarang dipindah sepenuhnya ke model & tabel User.

    protected $fillable = [
        'cno', 'kdcab', 'inisial', 'nmdealer', 'cnm', 'ad1', 'ad2', 'kota', 
        'dlmou', 'dlmoutglfr', 'dlmoutglto', 'alamat', 'nopic', 'clprnoktp',
    ];

    // 1. Relasi ke tabel mobil (Sudah Benar)
    public function cars()
    {
        return $this->hasMany(Car::class, 'no_cif', 'cno');
    }

    // 2. Relasi BARU ke tabel users (Satu showroom dipegang oleh satu akun login)
    public function user()
    {
        return $this->hasOne(User::class, 'showroom_id', 'id');
    }
}