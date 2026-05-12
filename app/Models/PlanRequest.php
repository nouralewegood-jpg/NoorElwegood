<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRequest extends Model
{
    use HasFactory;

    /**
     * الحقول القابلة للتعبئة
     *
     * @var array
     */
    protected $fillable = [
        'client_name',
        'phone_number',
        'country_code',
        'country',
        'project_details',
        'plan_name',
        'plan_price',
        'plan_period',
        'status',
        'admin_notes',
    ];

    /**
     * الحصول على النص الخاص بحالة الطلب
     *
     * @return string
     */
    public function getStatusText()
    {
        return match ($this->status) {
            'new' => 'جديد',
            'in_progress' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => 'غير محدد'
        };
    }

    /**
     * الحصول على لون حالة الطلب
     *
     * @return string
     */
    public function getStatusColor()
    {
        return match ($this->status) {
            'new' => 'primary',
            'in_progress' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * الحصول على رقم الهاتف الكامل مع مفتاح الدولة
     *
     * @return string
     */
    public function getFullPhoneNumber()
    {
        return $this->country_code . $this->phone_number;
    }
}
