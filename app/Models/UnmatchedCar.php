<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnmatchedCar extends Model
{
    use HasFactory;

    protected $table = 'unmatched_cars';
    protected $guarded = ['id'];
}