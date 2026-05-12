<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_section_id',
        'feature_text',
        'is_active',
        'ordering'
    ];

    public function aboutSection()
    {
        return $this->belongsTo(AboutSection::class);
    }
}
