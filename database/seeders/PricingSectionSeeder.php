<?php

namespace Database\Seeders;

use App\Models\PricingSection;
use Illuminate\Database\Seeder;

class PricingSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PricingSection::create([
            'title' => 'باقات خدمات الصيانة والديكور',
            'description' => 'اختر الباقة الأنسب لاحتياجاتك من بين باقاتنا الشاملة لخدمات الصيانة العامة والديكور. كل باقة مصممة لتوفر أفضل قيمة وجودة عالية.',
            'is_active' => true,
        ]);
    }
}
