<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pricing_section_id',
        'plan_name',
        'plan_badge',
        'price',
        'currency',
        'price_period',
        'is_featured',
        'btn_text',
        'btn_link',
        'is_active',
        'ordering'
    ];

    public function pricingSection()
    {
        return $this->belongsTo(PricingSection::class);
    }

    public function features()
    {
        return $this->hasMany(PricingFeature::class);
    }
}
