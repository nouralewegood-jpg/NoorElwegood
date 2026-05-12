<?php

namespace Database\Seeders;

use App\Models\ServiceItem;
use App\Models\ServiceSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateServiceItemsSectionIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على أول قسم خدمات (أو إنشاء واحد إذا لم يكن موجودًا)
        $section = ServiceSection::first();

        if (!$section) {
            $section = ServiceSection::create([
                'title' => 'قسم الخدمات',
                'description' => 'وصف قسم الخدمات',
                'is_active' => true
            ]);
        }

        // تحديث جميع عناصر الخدمات لتكون مرتبطة بقسم الخدمات المناسب
        ServiceItem::whereNull('service_section_id')->update([
            'service_section_id' => $section->id
        ]);
    }
}
