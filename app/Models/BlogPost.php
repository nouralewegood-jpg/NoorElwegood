<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Automatically generate slug from title
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_post_tag');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Record view count
    public function recordView()
    {
        $this->increment('views');
    }

    // Get next post
    public function getNextPost()
    {
        return self::published()
            ->where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    // Get previous post
    public function getPreviousPost()
    {
        return self::published()
            ->where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    // Get related posts by category
    public function getRelatedPosts($limit = 3)
    {
        return self::published()
            ->where('id', '!=', $this->id)
            ->where('blog_category_id', $this->blog_category_id)
            ->limit($limit)
            ->get();
    }
}
