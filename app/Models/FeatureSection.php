<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    public function items()
    {
        return $this->hasMany(FeatureItem::class);
    }
}
