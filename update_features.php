<?php

// تحميل مكتبة Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AboutFeature;
use App\Models\AboutSection;
use Illuminate\Support\Facades\DB;

// الحصول على قسم "من نحن"
$section = AboutSection::first();

if (!$section) {
    echo "إنشاء قسم 'من نحن' جديد...\n";
    $section = AboutSection::create([
        'title' => 'من نحن',
        'is_active' => true
    ]);
}

echo "تحديث ميزات قسم 'من نحن'...\n";

// تحديث جميع الميزات وربطها بقسم "من نحن"
$updated = DB::table('about_features')
    ->update(['about_section_id' => $section->id]);

echo "تم تحديث {$updated} ميزة.\n";
echo "تم الانتهاء بنجاح!\n";
