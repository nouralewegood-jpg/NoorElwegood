<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'subtitle',
        'is_active',
        'ordering'
    ];

    // نزيل العلاقة المشكلة التي تتسبب في الخطأ
    // public function homeSection()
    // {
    //     return $this->belongsTo(HomeSection::class);
    // }
}
