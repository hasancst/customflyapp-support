<?php

namespace App\Modul\Portofolio\Model;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $table = 'portofolios';
    protected $guarded = [];

    protected $casts = [
        'galeri' => 'array',
    ];

    /**
     * Kembalikan seluruh gambar portofolio (cover + galeri, maksimal 5).
     */
    public function semuaGambar(): array
    {
        $items = array_merge([$this->gambar], is_array($this->galeri) ? $this->galeri : []);
        return array_slice(array_values(array_filter($items)), 0, 5);
    }
}
