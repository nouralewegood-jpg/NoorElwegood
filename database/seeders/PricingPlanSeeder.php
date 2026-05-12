<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use App\Models\PricingSection;
use App\Models\PricingFeature;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the pricing section ID (or use 1 if none exists)
        $pricingSectionId = PricingSection::first()?->id ?? 1;

        // Create basic plan
        $basicPlan = PricingPlan::create([
            'pricing_section_id' => $pricingSectionId,
            'plan_name' => 'باقة الصيانة الأساسية',
            'plan_badge' => 'أساسية',
            'price' => '1499',
            'price_period' => 'شهرياً',
            'is_featured' => false,
            'btn_text' => 'تواصل الآن',
            'btn_link' => '/contact?plan=basic',
            'is_active' => true,
            'ordering' => 1,
        ]);

        // Create features for basic plan
        $this->createPlanFeatures($basicPlan->id, [
            ['feature_text' => 'تشخيص أولي مجاني', 'is_included' => true],
            ['feature_text' => 'خدمات صيانة أساسية', 'is_included' => true],
            ['feature_text' => 'أعمال دهان للغرف (حتى 3 غرف)', 'is_included' => true],
            ['feature_text' => 'إصلاحات سباكة بسيطة', 'is_included' => true],
            ['feature_text' => 'إصلاحات كهرباء بسيطة', 'is_included' => true],
            ['feature_text' => 'ضمان 6 أشهر على الأعمال', 'is_included' => true],
            ['feature_text' => 'أعمال جبس بورد', 'is_included' => false],
            ['feature_text' => 'تركيب بلاط وسيراميك', 'is_included' => false],
        ]);

        // Create standard plan
        $standardPlan = PricingPlan::create([
            'pricing_section_id' => $pricingSectionId,
            'plan_name' => 'باقة الصيانة المتكاملة',
            'plan_badge' => 'الأكثر طلباً',
            'price' => '3999',
            'price_period' => 'شهرياً',
            'is_featured' => true,
            'btn_text' => 'اختر هذه الباقة',
            'btn_link' => '/contact?plan=standard',
            'is_active' => true,
            'ordering' => 2,
        ]);

        // Create features for standard plan
        $this->createPlanFeatures($standardPlan->id, [
            ['feature_text' => 'جميع خدمات الباقة الأساسية', 'is_included' => true],
            ['feature_text' => 'أعمال دهان كامل للمنزل أو المكتب', 'is_included' => true],
            ['feature_text' => 'تركيب سيراميك حتى 100 متر مربع', 'is_included' => true],
            ['feature_text' => 'تركيب وحدات جبس بورد أساسية', 'is_included' => true],
            ['feature_text' => 'صيانة كاملة للأنظمة الكهربائية', 'is_included' => true],
            ['feature_text' => 'صيانة كاملة لأنظمة السباكة', 'is_included' => true],
            ['feature_text' => 'ضمان لمدة سنة على جميع الأعمال', 'is_included' => true],
            ['feature_text' => 'خدمات أعمال الرخام', 'is_included' => false],
            ['feature_text' => 'خدمات أعمال الحدادة', 'is_included' => false],
        ]);

        // Create premium plan
        $premiumPlan = PricingPlan::create([
            'pricing_section_id' => $pricingSectionId,
            'plan_name' => 'باقة الديكور الشاملة',
            'plan_badge' => 'متميزة',
            'price' => '7999',
            'price_period' => 'شهرياً',
            'is_featured' => false,
            'btn_text' => 'احصل على أفضل خدمة',
            'btn_link' => '/contact?plan=premium',
            'is_active' => true,
            'ordering' => 3,
        ]);

        // Create features for premium plan
        $this->createPlanFeatures($premiumPlan->id, [
            ['feature_text' => 'جميع خدمات الباقة المتكاملة', 'is_included' => true],
            ['feature_text' => 'تصميم وتنفيذ ديكور كامل', 'is_included' => true],
            ['feature_text' => 'تركيب أسقف جبس بورد معقدة', 'is_included' => true],
            ['feature_text' => 'تركيب وحدات إضاءة متخصصة', 'is_included' => true],
            ['feature_text' => 'تركيب بديل رخام أو خشب', 'is_included' => true],
            ['feature_text' => 'تركيب مغاسل رخام حسب الطلب', 'is_included' => true],
            ['feature_text' => 'خدمات الحدادة المتخصصة', 'is_included' => true],
            ['feature_text' => 'استشارات تصميم مجانية', 'is_included' => true],
            ['feature_text' => 'ضمان لمدة سنتين على جميع الأعمال', 'is_included' => true],
            ['feature_text' => 'خدمات صيانة دورية لمدة 6 أشهر', 'is_included' => true],
        ]);
    }

    /**
     * Create features for a pricing plan
     */
    private function createPlanFeatures(int $planId, array $features): void
    {
        foreach ($features as $index => $feature) {
            PricingFeature::create([
                'pricing_plan_id' => $planId,
                'feature_text' => $feature['feature_text'],
                'is_included' => $feature['is_included'],
                'ordering' => $index + 1,
            ]);
        }
    }
}
