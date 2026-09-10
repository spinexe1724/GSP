<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnmatchedPhoto extends Model
{
    use HasFactory;

    protected $table = 'unmatched_photos';
    protected $guarded = ['id'];
}