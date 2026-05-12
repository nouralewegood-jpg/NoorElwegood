<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use App\Models\PricingSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdatePricingPlansSectionIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على أول قسم تسعير (أو إنشاء واحد إذا لم يكن موجودًا)
        $section = PricingSection::first();

        if (!$section) {
            $section = PricingSection::create([
                'title' => 'قسم التسعير',
                'description' => 'وصف قسم التسعير',
                'is_active' => true
            ]);
        }

        // تحديث جميع خطط التسعير لتكون مرتبطة بقسم التسعير هذا
        PricingPlan::whereNull('pricing_section_id')->update([
            'pricing_section_id' => $section->id
        ]);
    }
}
