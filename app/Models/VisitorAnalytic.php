<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'country',
        'city',
        'page_url',
        'page_title',
        'referrer_url',
        'device_type',
        'browser',
        'os',
        'visit_duration',
        'is_unique',
        'is_bounce'
    ];
}
