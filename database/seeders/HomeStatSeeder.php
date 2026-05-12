<?php

namespace Database\Seeders;

use App\Models\HomeStat;
use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the home section ID (or use 1 if none exists)
        $homeSectionId = HomeSection::first()?->id ?? 1;

        // Create statistics for the home page
        HomeStat::create([
            'home_section_id' => $homeSectionId,
            'icon' => 'bi bi-people-fill',
            'title' => '10+',
            'subtitle' => 'سنوات خبرة',
            'is_active' => true,
            'ordering' => 1,
        ]);

        HomeStat::create([
            'home_section_id' => $homeSectionId,
            'icon' => 'bi bi-building-fill',
            'title' => '850+',
            'subtitle' => 'مشروع منجز',
            'is_active' => true,
            'ordering' => 2,
        ]);

        HomeStat::create([
            'home_section_id' => $homeSectionId,
            'icon' => 'bi bi-star-fill',
            'title' => '99%',
            'subtitle' => 'رضا العملاء',
            'is_active' => true,
            'ordering' => 3,
        ]);

        HomeStat::create([
            'home_section_id' => $homeSectionId,
            'icon' => 'bi bi-tools',
            'title' => '10+',
            'subtitle' => 'خدمات متنوعة',
            'is_active' => true,
            'ordering' => 4,
        ]);
    }
}
