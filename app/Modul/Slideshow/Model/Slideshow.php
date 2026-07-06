<?php

namespace App\Modul\Slideshow\Model;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $table = 'slideshow';
    protected $fillable = ['judul', 'deskripsi', 'badge_1', 'badge_2', 'gambar', 'url', 'urutan', 'aktif'];
}
