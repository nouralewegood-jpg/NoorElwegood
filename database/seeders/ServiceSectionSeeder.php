<?php

namespace Database\Seeders;

use App\Models\ServiceSection;
use Illuminate\Database\Seeder;

class ServiceSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceSection::create([
            'meta_text' => 'خدماتنا',
            'title' => 'خدمات الصيانة العامة والديكور المتكاملة',
            'description' => 'نقدم في شركة نور الوجود مجموعة متنوعة من خدمات الصيانة والديكور عالية الجودة في الإمارات. نحن متخصصون في خدمات الدهانات، الجبس بورد، بديل الخشب، بديل الرخام، السباكة، الكهرباء، تركيب السيراميك وتجارة الرخام. نلتزم بتقديم أفضل الخدمات بأعلى معايير الجودة لتلبية جميع احتياجات عملائنا.',
            'is_active' => true,
        ]);
    }
}
