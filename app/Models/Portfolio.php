<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Portfolio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'client_name',
        'project_date',
        'tags',
        'image',
        'gallery',
        'display_order',
        'is_featured',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gallery' => 'array',
        'project_date' => 'date',
        'is_featured' => 'boolean',
        'active' => 'boolean',
    ];

    /**
     * قواعد التحقق عند إنشاء عمل جديد
     */
    public static $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:100',
        'client_name' => 'nullable|string|max:100',
        'project_date' => 'nullable|date',
        'tags' => 'nullable|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'display_order' => 'nullable|integer|min:0',
        'is_featured' => 'nullable|boolean',
        'active' => 'nullable|boolean',
    ];

    /**
     * قواعد التحقق عند تحديث عمل موجود
     */
    public static $updateRules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'nullable|string|max:100',
        'client_name' => 'nullable|string|max:100',
        'project_date' => 'nullable|date',
        'tags' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'display_order' => 'nullable|integer|min:0',
        'is_featured' => 'nullable|boolean',
        'active' => 'nullable|boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // ترتيب افتراضي للأعمال
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('display_order', 'asc');
        });

        // حذف الصور عند حذف العمل
        static::deleting(function ($portfolio) {
            // حذف الصورة الرئيسية
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }

            // حذف الصور في معرض الصور
            if ($portfolio->gallery) {
                foreach ($portfolio->gallery as $galleryImage) {
                    Storage::disk('public')->delete($galleryImage);
                }
            }
        });
    }

    /**
     * الحصول على مسار الصورة
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : '/assets-home/img/portfolio/default.jpg';
    }

    /**
     * الحصول على مصفوفة بمسارات الصور في المعرض
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }

        return array_map(function ($image) {
            return Storage::url($image);
        }, $this->gallery);
    }

    /**
     * الحصول على مصفوفة بكائنات صور المعرض
     */
    public function getGalleryImagesAttribute()
    {
        if (!$this->gallery) {
            return collect([]);
        }

        // تحويل مصفوفة المسارات إلى collection من الكائنات
        return collect($this->gallery)->map(function ($imagePath, $index) {
            return (object) [
                'id' => $index,
                'image_url' => Storage::url($imagePath),
                'title' => $this->title . ' - صورة ' . ($index + 1),
            ];
        });
    }

    /**
     * الحصول على مصفوفة بالوسوم
     */
    public function getTagsArrayAttribute()
    {
        if (!$this->tags) {
            return [];
        }

        return array_map('trim', explode(',', $this->tags));
    }

    /**
     * الحصول على الأعمال ذات الصلة
     */
    public function getRelatedWorksAttribute()
    {
        // البحث عن أعمال من نفس التصنيف
        if ($this->category) {
            $relatedByCategory = self::active()
                ->where('id', '!=', $this->id)
                ->where('category', $this->category)
                ->take(3)
                ->get();

            if ($relatedByCategory->count() >= 3) {
                return $relatedByCategory;
            }

            // إذا لم نجد عدد كافي من الأعمال
            $remaining = 3 - $relatedByCategory->count();
            $excludeIds = $relatedByCategory->pluck('id')->push($this->id)->toArray();

            // البحث عن أعمال إضافية
            $others = self::active()
                ->whereNotIn('id', $excludeIds)
                ->take($remaining)
                ->get();

            return $relatedByCategory->concat($others);
        }

        // إذا لم يكن هناك تصنيف، اختر أعمال عشوائية
        return self::active()
            ->where('id', '!=', $this->id)
            ->inRandomOrder()
            ->take(3)
            ->get();
    }

    /**
     * نطاق الأعمال النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * نطاق الأعمال المميزة
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * نطاق ترتيب الأعمال حسب الترتيب
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }
}
