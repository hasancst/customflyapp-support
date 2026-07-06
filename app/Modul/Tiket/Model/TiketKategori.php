<?php

namespace App\Modul\Tiket\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TiketKategori extends Model
{
    protected $table = 'tiket_categories';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(TiketKategori::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TiketKategori::class, 'parent_id')->orderBy('urutan');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'category_id');
    }
}
