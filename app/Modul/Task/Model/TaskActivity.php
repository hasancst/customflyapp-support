<?php

namespace App\Modul\Task\Model;

use Illuminate\Database\Eloquent\Model;

class TaskActivity extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'changes' => 'array'
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
