<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_enabled',
        'track_bots',
        'data_retention_days'
    ];

    /**
     * تحويل القيم المسترجعة إلى قيم منطقية
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'track_bots' => 'boolean',
    ];

    /**
     * الحصول على إعدادات التحليلات الحالية أو إنشاء إعدادات افتراضية
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'is_enabled' => true,
                'track_bots' => false,
                'data_retention_days' => 90
            ]);
        }
        
        return $settings;
    }
}
