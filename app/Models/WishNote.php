<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishNote extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi_singkat',
        'tipe_wadah',
        'privasi',
    ];           
}
