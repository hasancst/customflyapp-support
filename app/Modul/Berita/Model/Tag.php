<?php

namespace App\Modul\Berita\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag_berita';
    protected $fillable = ['nama', 'slug'];

    public function berita()
    {
        return $this->belongsToMany(Berita::class, 'berita_memiliki_tag', 'tag_id', 'berita_id');
    }
}
