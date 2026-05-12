<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'subject',
        'message',
        'is_read',
        'ip_address',
        'user_agent',
        'is_suspicious',
        'security_notes',
        'blocked_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_suspicious' => 'boolean',
        'blocked_at' => 'datetime',
    ];

    /**
     * تحديد ما إذا كانت الرسالة مشبوهة
     *
     * @return boolean
     */
    public function isSuspicious()
    {
        return $this->is_suspicious;
    }

    /**
     * تحديد ما إذا كانت الرسالة محظورة
     *
     * @return boolean
     */
    public function isBlocked()
    {
        return !is_null($this->blocked_at);
    }

    /**
     * وضع علامة على الرسالة كمشبوهة
     *
     * @param string $reason سبب اعتبار الرسالة مشبوهة
     * @return void
     */
    public function markAsSuspicious($reason = null)
    {
        $this->is_suspicious = true;

        if ($reason) {
            $notes = $this->security_notes ? json_decode($this->security_notes, true) : [];
            $notes[] = [
                'time' => now()->toDateTimeString(),
                'reason' => $reason,
                'action' => 'marked_suspicious'
            ];
            $this->security_notes = json_encode($notes);
        }

        $this->save();
    }

    /**
     * حظر الرسالة
     *
     * @param string $reason سبب الحظر
     * @return void
     */
    public function block($reason = null)
    {
        $this->blocked_at = now();

        if ($reason) {
            $notes = $this->security_notes ? json_decode($this->security_notes, true) : [];
            $notes[] = [
                'time' => now()->toDateTimeString(),
                'reason' => $reason,
                'action' => 'blocked'
            ];
            $this->security_notes = json_encode($notes);
        }

        $this->save();
    }
}
