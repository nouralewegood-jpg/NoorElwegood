<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsOfService extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للملء
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
        'last_updated_at',
    ];

    /**
     * تحويل الحقول إلى أنواع البيانات المناسبة
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'last_updated_at' => 'datetime',
    ];
}
