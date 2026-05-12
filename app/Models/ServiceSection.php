<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_text',
        'title',
        'description',
        'is_active',
    ];

    public function items()
    {
        return $this->hasMany(ServiceItem::class);
    }
}
