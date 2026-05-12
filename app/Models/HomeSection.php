<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_badge',
        'main_title_line1',
        'main_title_line2',
        'main_title_line3',
        'description',
        'btn_text',
        'btn_link',
        'video_btn_text',
        'video_link',
        'hero_image',
        'customer_count',
        'customer_text',
        'is_active',
        'ordering',
    ];

    // تعليق العلاقة المسببة للمشكلة
    // public function stats()
    // {
    //     return $this->hasMany(HomeStat::class);
    // }
}
