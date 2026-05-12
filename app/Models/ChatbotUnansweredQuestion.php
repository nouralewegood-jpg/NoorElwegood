<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotUnansweredQuestion extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن ملؤها
     */
    protected $fillable = [
        'question',
        'answer',
        'frequency',
        'status',
        'last_asked_at',
        'answered_at',
        'transferred_at'
    ];

    /**
     * الحقول التي يجب تحويلها إلى تواريخ
     */
    protected $dates = [
        'last_asked_at',
        'answered_at',
        'transferred_at',
        'created_at',
        'updated_at'
    ];

    /**
     * الحقول التي يجب تحويلها إلى أنواع معينة
     */
    protected $casts = [
        'frequency' => 'integer',
    ];

    /**
     * نقل السؤال إلى إعدادات الشات بوت
     *
     * @return ChatbotSetting|null
     */
    public function transferToSettings()
    {
        if ($this->status !== 'answered' || empty($this->answer)) {
            return null;
        }

        // إنشاء إعداد جديد للشات بوت
        $setting = ChatbotSetting::create([
            'key' => $this->question,
            'value' => $this->answer,
            'type' => 'text',
            'active' => true
        ]);

        // تحديث حالة السؤال
        $this->update([
            'status' => 'transferred',
            'transferred_at' => now()
        ]);

        return $setting;
    }
}
