<?php

namespace Database\Seeders;

use App\Models\AboutFeature;
use App\Models\AboutSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateAboutFeaturesSectionIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على أول قسم عن الشركة (أو إنشاء واحد إذا لم يكن موجودًا)
        $section = AboutSection::first();

        if (!$section) {
            $section = AboutSection::create([
                'title' => 'عن الشركة',
                'description' => 'وصف عن الشركة',
                'is_active' => true
            ]);
        }

        // تحديث جميع ميزات قسم About لتكون مرتبطة بالقسم المناسب
        AboutFeature::whereNull('about_section_id')->update([
            'about_section_id' => $section->id
        ]);
    }
}
