<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Automatically generate slug from name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Relationships
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag');
    }

    // Get post count
    public function getPostCountAttribute()
    {
        return $this->posts()->published()->count();
    }
}
