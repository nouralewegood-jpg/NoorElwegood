<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'phone',
        'whatsapp_number',  // إضافة حقل رقم الواتساب
        'email',
        'map_lat',
        'map_lng',
        'map_zoom',
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'social_linkedin',
        'is_active',
    ];
}
