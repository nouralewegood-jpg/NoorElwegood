<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للملء
     */
    protected $fillable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
        'last_updated_at'
    ];

    /**
     * الحقول التي يجب معاملتها كتواريخ
     */
    protected $dates = [
        'last_updated_at',
        'created_at',
        'updated_at'
    ];

    /**
     * الحقول التي تحول من/إلى قيم بوليانية
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
