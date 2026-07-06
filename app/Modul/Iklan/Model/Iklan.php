<?php

namespace App\Modul\Iklan\Model;

use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    protected $table = 'iklan';
    protected $fillable = ['judul', 'jenis', 'konten', 'posisi', 'link', 'aktif'];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
