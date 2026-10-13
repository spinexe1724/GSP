<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Showroom extends Authenticatable
{
    protected $fillable = [
        'cno','kdcab', 'inisial', 'nmdealer','cnm','ad1', 'ad2','kota', 
        'dlmou', 'dlmoutglfr', 'dlmoutglto', 'alamat','nopic','clprnoktp',
    ];
use HasFactory;
use Notifiable;

    protected $table = 'showrooms';
    protected $guarded = ['id'];
protected $hidden = [
        'password',
    ];
    public function cars()
    {
        return $this->hasMany(Car::class, 'no_cif', 'cno');
    }
}


