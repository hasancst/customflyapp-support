<?php

namespace App\Modul\Tiket\Model;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tikets';
    protected $guarded = [];

    public function pesans()
    {
        return $this->hasMany(TiketPesan::class, 'tiket_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function tiketKategori()
    {
        return $this->belongsTo(TiketKategori::class, 'category_id');
    }

    public function lampiran()
    {
        return $this->hasMany(TiketLampiran::class, 'tiket_id');
    }
}
