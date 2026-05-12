<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeSection::create([
            'company_badge' => 'شركة صيانة وديكور رائدة في الإمارات',
            'main_title_line1' => 'خدمات الصيانة',
            'main_title_line2' => 'والديكور المتكاملة',
            'main_title_line3' => 'بأعلى جودة',
            'description' => 'شركة نور الوجود هي شركة متخصصة في خدمات الدهانات، الجبس بورد، بديل الخشب والرخام، السباكة، الكهرباء، تركيب السيراميك وتجارة الرخام في الإمارات العربية المتحدة',
            'btn_text' => 'تواصل معنا الآن',
            'btn_link' => '/contact',
            'video_btn_text' => 'شاهد أعمالنا',
            'video_link' => 'https://www.youtube.com/watch?v=ABCxyz',
            'hero_image' => 'assets-home/img/hero.jpg',
            'customer_count' => '1000+',
            'customer_text' => 'عميل سعيد في الإمارات',
            'is_active' => true,
            'ordering' => 1,
        ]);
    }
}
