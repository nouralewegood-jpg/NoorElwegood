<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_section_id',
        'icon',
        'title',
        'short_description',
        'description',
        'image',
        'is_active',
        'ordering'
    ];

    public function serviceSection()
    {
        return $this->belongsTo(ServiceSection::class);
    }
}
