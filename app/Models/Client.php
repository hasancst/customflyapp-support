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
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
