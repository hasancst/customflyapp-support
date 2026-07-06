<?php

namespace App\Modul\Chat\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatWidget extends Model
{
    protected $fillable = [
        'nama',
        'public_key',
        'secret_key',
        'domain',
        'pengaturan',
        'aktif'
    ];

    protected $casts = [
        'pengaturan' => 'array',
        'aktif' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($widget) {
            $widget->public_key = 'pk_' . Str::random(32);
            $widget->secret_key = 'sk_' . Str::random(32);
        });
    }

    public function sessions()
    {
        return $this->hasMany(ChatSession::class, 'widget_id');
    }
}
