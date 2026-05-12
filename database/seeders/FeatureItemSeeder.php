<?php

namespace Database\Seeders;

use App\Models\FeatureItem;
use App\Models\FeatureSection;
use Illuminate\Database\Seeder;

class FeatureItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the feature section ID (or use 1 if none exists)
        $featureSectionId = FeatureSection::first()?->id ?? 1;

        $features = [
            [
                'tab_name' => 'فريق متخصص',
                'icon' => 'bi bi-people',
                'title' => 'فريق محترف',
                'description' => 'فريق ماهر من خبراء الصيانة والديكور لضمان أفضل جودة في التنفيذ',
                'is_active' => true,
                'ordering' => 1,
            ],
            [
                'tab_name' => 'جودة',
                'icon' => 'bi bi-award',
                'title' => 'جودة مضمونة',
                'description' => 'نستخدم أجود المواد وأفضل الأدوات لتقديم نتائج دائمة وراقية',
                'is_active' => true,
                'ordering' => 2,
            ],
            [
                'tab_name' => 'سرعة',
                'icon' => 'bi bi-clock',
                'title' => 'التزام بالمواعيد',
                'description' => 'إنجاز المشاريع في الوقت المتفق عليه دون تأخيرات',
                'is_active' => true,
                'ordering' => 3,
            ],
            [
                'tab_name' => 'مواد',
                'icon' => 'bi bi-box-seam',
                'title' => 'مواد عالية الجودة',
                'description' => 'اختيار أفضل المواد المقاومة للرطوبة والخدوش لضمان متانة عالية',
                'is_active' => true,
                'ordering' => 4,
            ],
            [
                'tab_name' => 'ضمان',
                'icon' => 'bi bi-shield-check',
                'title' => 'ضمان الخدمة',
                'description' => 'تقديم ضمان على الأعمال المنفذة لتوفير راحة البال للعملاء',
                'is_active' => true,
                'ordering' => 5,
            ],
            [
                'tab_name' => 'تغطية',
                'icon' => 'bi bi-geo-alt',
                'title' => 'تغطية شاملة',
                'description' => 'خدماتنا متوفرة في جميع أنحاء أبو ظبي والعين',
                'is_active' => true,
                'ordering' => 6,
            ],
        ];

        foreach ($features as $feature) {
            FeatureItem::create([
                'feature_section_id' => $featureSectionId,
                'tab_name' => $feature['tab_name'],
                'icon' => $feature['icon'],
                'title' => $feature['title'],
                'description' => $feature['description'],
                'is_active' => $feature['is_active'],
                'ordering' => $feature['ordering'],
            ]);
        }
    }
}
