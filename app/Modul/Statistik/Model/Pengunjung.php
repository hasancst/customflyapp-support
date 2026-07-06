<?php

namespace App\Modul\Statistik\Model;

use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    protected $table = 'stat_pengunjung';
    protected $fillable = ['ip', 'negara', 'kode_negara', 'perangkat', 'url', 'referensi', 'tanggal'];
}
