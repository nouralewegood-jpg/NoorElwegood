<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'response',
        'ip_address',
        'user_agent',
        'is_suspicious',
        'blocked_at'
    ];

    protected $casts = [
        'is_suspicious' => 'boolean',
        'blocked_at' => 'datetime',
    ];
}
