<?php

namespace App\Modul\Chat\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Modul\Tiket\Model\Tiket;

class ChatSession extends Model
{
    protected $fillable = [
        'widget_id',
        'session_token',
        'nama_pengunjung',
        'email_pengunjung',
        'ip_pengunjung',
        'user_agent',
        'halaman_url',
        'status',
        'tiket_id',
        'aktivitas_terakhir'
    ];

    protected $casts = [
        'aktivitas_terakhir' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($session) {
            $session->session_token = Str::random(64);
            $session->aktivitas_terakhir = now();
        });
    }

    public function widget()
    {
        return $this->belongsTo(ChatWidget::class, 'widget_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }

    public function updateAktivitas()
    {
        $this->update(['aktivitas_terakhir' => now()]);
    }
}
