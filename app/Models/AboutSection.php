<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_text',
        'title',
        'description',
        'main_image',
        'secondary_image',
        'ceo_name',
        'ceo_position',
        'ceo_image',
        'phone_label',
        'phone_number',
        'years_experience',
        'experience_text',
        'is_active',
    ];

    public function features()
    {
        return $this->hasMany(AboutFeature::class);
    }
}
