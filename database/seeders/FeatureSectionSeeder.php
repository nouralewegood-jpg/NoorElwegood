<?php

namespace Database\Seeders;

use App\Models\FeatureSection;
use Illuminate\Database\Seeder;

class FeatureSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeatureSection::create([
            'title' => 'لماذا تختار نور الوجود؟',
            'description' => 'نتميز بخبرة عالية في خدمات الصيانة والديكور، وفريق متخصص، وجودة مضمونة، وأسعار تنافسية، والتزام تام بالمواعيد، ودعم ما بعد التنفيذ.',
            'is_active' => true,
        ]);
    }
}
