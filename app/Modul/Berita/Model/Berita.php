<?php

namespace App\Modul\Berita\Model;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    protected $table = 'berita';
    protected $fillable = ['judul', 'slug', 'ringkasan', 'isi', 'penulis_id', 'gambar_utama', 'unggulan'];

    protected $casts = [
        'unggulan' => 'boolean',
    ];

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'berita_memiliki_kategori', 'berita_id', 'kategori_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'berita_memiliki_tag', 'berita_id', 'tag_id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
