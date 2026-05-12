<?php

namespace Database\Seeders;

use App\Models\AboutFeature;
use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class AboutFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the about section ID (or use 1 if none exists)
        $aboutSectionId = AboutSection::first()?->id ?? 1;

        // Create features for about section
        $features = [
            [
                'feature_text' => 'خدمات صيانة عامة بأعلى معايير الجودة',
                'is_active' => true,
                'ordering' => 1,
            ],
            [
                'feature_text' => 'أعمال دهانات احترافية للمنازل والمكاتب',
                'is_active' => true,
                'ordering' => 2,
            ],
            [
                'feature_text' => 'تركيب جميع أنواع السيراميك والبلاط',
                'is_active' => true,
                'ordering' => 3,
            ],
            [
                'feature_text' => 'أعمال الجبس بورد والأسقف المستعارة',
                'is_active' => true,
                'ordering' => 4,
            ],
            [
                'feature_text' => 'تجارة وتركيب الرخام بجميع أنواعه',
                'is_active' => true,
                'ordering' => 5,
            ],
            [
                'feature_text' => 'خدمات السباكة والكهرباء والحدادة',
                'is_active' => true,
                'ordering' => 6,
            ],
        ];

        foreach ($features as $feature) {
            AboutFeature::create([
                'about_section_id' => $aboutSectionId,
                'feature_text' => $feature['feature_text'],
                'is_active' => $feature['is_active'],
                'ordering' => $feature['ordering'],
            ]);
        }
    }
}
