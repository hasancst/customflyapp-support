<?php

namespace App\Modul\Knowledgebase\Model;

use Illuminate\Database\Eloquent\Model;

class KBArticle extends Model
{
    protected $table = 'kb_articles';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(KBCategory::class, 'category_id');
    }
}
