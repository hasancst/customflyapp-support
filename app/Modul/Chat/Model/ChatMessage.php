<?php

namespace App\Modul\Chat\Model;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'pengirim',
        'pesan',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function session()
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}
