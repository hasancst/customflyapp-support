<?php

namespace App\Modul\Tiket\Model;

use Illuminate\Database\Eloquent\Model;

class TiketLampiran extends Model
{
    protected $table = 'tiket_lampiran';
    protected $guarded = [];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }

    /**
     * Apakah file ini gambar
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Format ukuran file menjadi human-readable
     */
    public function ukuranFormatted(): string
    {
        $bytes = $this->ukuran;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }
}
