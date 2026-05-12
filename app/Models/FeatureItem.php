<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'feature_section_id',
        'tab_name',
        'title',
        'description',
        'image',
        'icon',
        'is_active',
        'ordering'
    ];

    public function featureSection()
    {
        return $this->belongsTo(FeatureSection::class);
    }
}
