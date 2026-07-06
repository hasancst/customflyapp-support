<?php

namespace App\Modul\Artikel\Model;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $fillable = ['judul', 'slug', 'isi', 'status', 'penulis_id'];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
