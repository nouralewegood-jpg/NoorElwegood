<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSection::create([
            'meta_text' => 'عن نور الوجود',
            'title' => 'نبذة عن شركة نور الوجود للصيانة العامة والديكور',
            'description' => 'شركة نور الوجود هي شركة رائدة في مجال خدمات الصيانة العامة والديكور في الإمارات العربية المتحدة. نحن متخصصون في خدمات الدهانات، الجبس بورد، بديل الخشب، بديل الرخام، السباكة، الكهرباء، تركيب السيراميك، وتجارة الرخام. نسعى دائمًا لتقديم أعلى معايير الجودة في جميع أعمالنا مع الالتزام بالمواعيد والدقة في التنفيذ. يمتلك فريقنا خبرة واسعة في تنفيذ المشاريع المختلفة للعملاء من الأفراد والشركات.',
            'main_image' => 'assets-home/img/about-main.jpg',
            'secondary_image' => 'assets-home/img/about-secondary.jpg',
            'ceo_name' => 'محمد نور',
            'ceo_position' => 'المدير العام',
            'ceo_image' => 'assets-home/img/ceo.jpg',
            'phone_label' => 'للاستشارات المجانية',
            'phone_number' => '+971508423094',
            'years_experience' => '10',
            'experience_text' => 'سنوات خبرة في مجال الصيانة والديكور',
            'is_active' => true,
        ]);
    }
}
