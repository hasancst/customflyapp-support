<?php

namespace App\Modul\Task\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modul\Tiket\Model\Tiket;
use App\Models\User;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'due_at' => 'datetime',
        'sla_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'ai_metadata' => 'array',
        'is_ai_generated' => 'boolean',
    ];

    // Relationships
    public function assignee() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tiket() {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }

    public function activities() {
        return $this->hasMany(TaskActivity::class)->latest();
    }

    public function subtasks() {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    // Scopes
    public function scopePending($query) {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeOverdue($query) {
        return $query->where('due_at', '<', now())->whereNull('completed_at');
    }
}
