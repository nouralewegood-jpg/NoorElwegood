<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'type', 'active', 'frequency'];

    protected $casts = [
        'active' => 'boolean',
        'frequency' => 'integer',
    ];
}
