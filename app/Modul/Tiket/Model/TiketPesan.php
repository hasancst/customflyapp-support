<?php

namespace App\Modul\Tiket\Model;

use Illuminate\Database\Eloquent\Model;

class TiketPesan extends Model
{
    protected $table = 'tiket_pesans';
    protected $guarded = [];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
