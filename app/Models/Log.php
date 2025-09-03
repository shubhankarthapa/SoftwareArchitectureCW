<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'application_name',
        'level',
        'message',
        'context',
        'source',
        'user_id',
        'session_id',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'context' => 'array',
    ];

    const LEVELS = [
        'debug' => 'debug',
        'info' => 'info',
        'warning' => 'warning',
        'error' => 'error',
        'critical' => 'critical'
    ];
}
