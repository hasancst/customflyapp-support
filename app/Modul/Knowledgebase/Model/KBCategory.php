<?php

namespace App\Modul\Knowledgebase\Model;

use Illuminate\Database\Eloquent\Model;

class KBCategory extends Model
{
    protected $table = 'kb_categories';
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(KBArticle::class, 'category_id')->where('aktif', true)->orderBy('urutan');
    }

    public function parent()
    {
        return $this->belongsTo(KBCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(KBCategory::class, 'parent_id')->orderBy('urutan');
    }
}
