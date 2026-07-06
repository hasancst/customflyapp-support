<?php

namespace App\Modul\Kontak\Model;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    protected $fillable = ['nama', 'email', 'perihal', 'pesan', 'status'];
}
