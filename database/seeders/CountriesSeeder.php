<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesSeeder extends Seeder
{
    /**
     * تشغيل بذرة قاعدة البيانات
     */
    public function run(): void
    {
        // تعريف بيانات الدول العربية
        $arabCountries = [
            [
                'name_ar' => 'مصر',
                'name_en' => 'Egypt',
                'country_code' => '+20',
                'code' => 'EG',
                'flag' => '🇪🇬',
                'min_length' => 10,
                'max_length' => 11,
                'sort_order' => 1,
            ],
            [
                'name_ar' => 'السعودية',
                'name_en' => 'Saudi Arabia',
                'country_code' => '+966',
                'code' => 'SA',
                'flag' => '🇸🇦',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 2,
            ],
            [
                'name_ar' => 'الإمارات',
                'name_en' => 'United Arab Emirates',
                'country_code' => '+971',
                'code' => 'AE',
                'flag' => '🇦🇪',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 3,
            ],
            [
                'name_ar' => 'قطر',
                'name_en' => 'Qatar',
                'country_code' => '+974',
                'code' => 'QA',
                'flag' => '🇶🇦',
                'min_length' => 8,
                'max_length' => 8,
                'sort_order' => 4,
            ],
            [
                'name_ar' => 'الكويت',
                'name_en' => 'Kuwait',
                'country_code' => '+965',
                'code' => 'KW',
                'flag' => '🇰🇼',
                'min_length' => 8,
                'max_length' => 8,
                'sort_order' => 5,
            ],
            [
                'name_ar' => 'عمان',
                'name_en' => 'Oman',
                'country_code' => '+968',
                'code' => 'OM',
                'flag' => '🇴🇲',
                'min_length' => 8,
                'max_length' => 8,
                'sort_order' => 6,
            ],
            [
                'name_ar' => 'البحرين',
                'name_en' => 'Bahrain',
                'country_code' => '+973',
                'code' => 'BH',
                'flag' => '🇧🇭',
                'min_length' => 8,
                'max_length' => 8,
                'sort_order' => 7,
            ],
            [
                'name_ar' => 'الأردن',
                'name_en' => 'Jordan',
                'country_code' => '+962',
                'code' => 'JO',
                'flag' => '🇯🇴',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 8,
            ],
            [
                'name_ar' => 'لبنان',
                'name_en' => 'Lebanon',
                'country_code' => '+961',
                'code' => 'LB',
                'flag' => '🇱🇧',
                'min_length' => 7,
                'max_length' => 8,
                'sort_order' => 9,
            ],
            [
                'name_ar' => 'سوريا',
                'name_en' => 'Syria',
                'country_code' => '+963',
                'code' => 'SY',
                'flag' => '🇸🇾',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 10,
            ],
            [
                'name_ar' => 'العراق',
                'name_en' => 'Iraq',
                'country_code' => '+964',
                'code' => 'IQ',
                'flag' => '🇮🇶',
                'min_length' => 10,
                'max_length' => 10,
                'sort_order' => 11,
            ],
            [
                'name_ar' => 'فلسطين',
                'name_en' => 'Palestine',
                'country_code' => '+970',
                'code' => 'PS',
                'flag' => '🇵🇸',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 12,
            ],
            [
                'name_ar' => 'المغرب',
                'name_en' => 'Morocco',
                'country_code' => '+212',
                'code' => 'MA',
                'flag' => '🇲🇦',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 13,
            ],
            [
                'name_ar' => 'الجزائر',
                'name_en' => 'Algeria',
                'country_code' => '+213',
                'code' => 'DZ',
                'flag' => '🇩🇿',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 14,
            ],
            [
                'name_ar' => 'تونس',
                'name_en' => 'Tunisia',
                'country_code' => '+216',
                'code' => 'TN',
                'flag' => '🇹🇳',
                'min_length' => 8,
                'max_length' => 8,
                'sort_order' => 15,
            ],
            [
                'name_ar' => 'ليبيا',
                'name_en' => 'Libya',
                'country_code' => '+218',
                'code' => 'LY',
                'flag' => '🇱🇾',
                'min_length' => 9,
                'max_length' => 10,
                'sort_order' => 16,
            ],
            [
                'name_ar' => 'السودان',
                'name_en' => 'Sudan',
                'country_code' => '+249',
                'code' => 'SD',
                'flag' => '🇸🇩',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 17,
            ],
            [
                'name_ar' => 'اليمن',
                'name_en' => 'Yemen',
                'country_code' => '+967',
                'code' => 'YE',
                'flag' => '🇾🇪',
                'min_length' => 9,
                'max_length' => 9,
                'sort_order' => 18,
            ],
        ];

        // إضافة دولة أخرى للاختيارات الأخرى
        $arabCountries[] = [
            'name_ar' => 'أخرى',
            'name_en' => 'Other',
            'country_code' => '',
            'code' => 'OT',
            'flag' => '🌍',
            'min_length' => 7,
            'max_length' => 15,
            'sort_order' => 99,
        ];

        // حذف البيانات القديمة إن وجدت ثم إدخال البيانات الجديدة
        Country::truncate();
        foreach ($arabCountries as $country) {
            Country::create($country);
        }
    }
}
