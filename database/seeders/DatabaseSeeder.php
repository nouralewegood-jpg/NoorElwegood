<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            HomeSectionSeeder::class,  // اضافة سيدر قسم الرئيسية
            HomeStatSeeder::class,     // اضافة سيدر احصائيات الرئيسية
            AboutSectionSeeder::class, // اضافة سيدر قسم من نحن
            AboutFeatureSeeder::class, // اضافة سيدر مميزات من نحن
            FeatureSectionSeeder::class, // اضافة سيدر قسم المميزات
            FeatureItemSeeder::class,    // اضافة سيدر عناصر المميزات
            ServiceSectionSeeder::class, // اضافة سيدر قسم الخدمات
            ServiceItemSeeder::class,    // اضافة سيدر عناصر الخدمات
            PricingSectionSeeder::class, // اضافة سيدر قسم الأسعار
            PricingPlanSeeder::class,    // اضافة سيدر خطط الأسعار
            ContactSectionSeeder::class, // اضافة سيدر قسم التواصل
            MessageSeeder::class,        // اضافة سيدر الرسائل
            BlogCategorySeeder::class,   // اضافة سيدر أقسام المدونة
            BlogPostSeeder::class,       // اضافة سيدر مقالات المدونة
            ChatbotSeeder::class,        // سيدر الشات بوت
            ChatbotSynonymSeeder::class, // سيدر المرادفات
            PrivacyPolicySeeder::class,  // سيدر سياسة الخصوصية
            TermsOfServiceSeeder::class, // سيدر شروط الخدمة
            CountriesSeeder::class,      // سيدر الدول ومفاتيح الهواتف
            PortfolioSeeder::class,      // سيدر معرض الأعمال
            // AnalyticsSettingsSeeder::class,
            // VisitorAnalyticsSeeder::class,
            ServiceBlogPostSeeder::class,
        ]);
    }
}
