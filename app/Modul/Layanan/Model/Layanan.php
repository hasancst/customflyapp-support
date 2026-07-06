<?php

namespace App\Modul\Layanan\Model;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanans';
    protected $fillable = ['judul', 'deskripsi', 'ikon', 'urutan', 'aktif'];
}
