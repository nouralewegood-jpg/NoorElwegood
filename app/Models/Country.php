<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة الجماعية
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'country_code',
        'code',
        'flag',
        'min_length',
        'max_length',
        'is_active',
        'sort_order'
    ];

    /**
     * الحقول التي يجب تحويلها إلى أنواع محددة
     *
     * @var array
     */
    protected $casts = [
        'min_length' => 'integer',
        'max_length' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * استعلام للحصول على الدول النشطة فقط
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * استعلام للترتيب حسب الأهمية
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name_ar', 'asc');
    }
}
