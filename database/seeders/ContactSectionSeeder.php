<?php

namespace Database\Seeders;

use App\Models\ContactSection;
use Illuminate\Database\Seeder;

class ContactSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSection::create([
            'title' => 'هل تحتاج لخدمات الصيانة أو الديكور؟ تواصل معنا',
            'description' => 'نحن في شركة نور الوجود نقدم خدمات الصيانة العامة والديكور بأعلى معايير الجودة. تواصل معنا الآن للحصول على استشارة مجانية ومناقشة احتياجاتك من خدمات الدهانات، الجبس بورد، تركيب السيراميك، السباكة والكهرباء وغيرها.',
            'address' => 'الإمارات العربية المتحدة',
            'email' => 'info@noorelwegood.com',
            'phone' => '+971508423094',
            'whatsapp_number' => '+971521526060 ',
            'map_lat' => '24.4539',
            'map_lng' => '54.3773',
            'map_zoom' => '15',
            'social_facebook' => 'https://facebook.com/noorelwegood',
            'social_twitter' => 'https://twitter.com/noorelwegood',
            'social_instagram' => 'https://instagram.com/noorelwegood',
            'social_linkedin' => 'https://linkedin.com/company/noorelwegood',
            'is_active' => true,
        ]);
    }
}
