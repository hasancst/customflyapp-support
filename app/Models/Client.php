<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'country',
        'shop_id',
        'shop_domain',
        'customer_id',
        'first_name',
        'last_name',
        'app',
        'plan',
        'phone',
        'status',
        'trial_used',
        'trial_started_at',
        'trial_ends_at',
        'trial_reminder_sent_at',
    ];

    protected $casts = [
        'trial_used'             => 'boolean',
        'trial_started_at'       => 'datetime',
        'trial_ends_at'          => 'datetime',
        'trial_reminder_sent_at' => 'datetime',
        'created_at'             => 'datetime',
        'updated_at'             => 'datetime',
    ];

    /**
     * Apakah client sedang dalam masa trial aktif
     */
    public function isOnTrial(): bool
    {
        return $this->trial_used
            && $this->trial_ends_at !== null
            && $this->trial_ends_at->isFuture();
    }

    /**
     * Sisa hari trial (null jika tidak sedang trial)
     */
    public function trialDaysLeft(): ?int
    {
        if (!$this->isOnTrial()) return null;
        return (int) now()->diffInDays($this->trial_ends_at, false);
    }
}
