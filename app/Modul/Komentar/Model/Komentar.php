<?php

namespace App\Modul\Komentar\Model;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Komentar extends Model
{
    protected $table = 'komentar';
    protected $fillable = ['komentabel_id', 'komentabel_type', 'user_id', 'nama', 'email', 'isi', 'status', 'ip_address'];

    public function komentabel()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Penamaan untuk tampilan admin
    public function getNamaPengirimAttribute()
    {
        return $this->user ? $this->user->nama : ($this->nama ?: 'Anonim');
    }
}
