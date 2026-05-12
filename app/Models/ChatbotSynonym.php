<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotSynonym extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها
     *
     * @var array
     */
    protected $fillable = ['main_word', 'synonyms', 'active'];

    /**
     * الحقول التي يجب معاملتها كمصفوفات
     *
     * @var array
     */
    protected $casts = [
        'synonyms' => 'array',
        'active' => 'boolean',
    ];
}
