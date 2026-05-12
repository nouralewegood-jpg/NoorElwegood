<?php

namespace App\Console\Commands;

use App\Models\AnalyticsSetting;
use App\Models\VisitorAnalytic;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class GenerateAnalyticsData extends Command
{
    /**
     * الاسم والوصف الخاصين بالأمر.
     *
     * @var string
     */
    protected $signature = 'analytics:generate-data {count=100 : عدد السجلات التي سيتم إنشاؤها}';

    /**
     * وصف الأمر.
     *
     * @var string
     */
    protected $description = 'إنشاء بيانات تجريبية لنظام تحليلات الزيارات';

    /**
     * تنفيذ الأمر.
     */
    public function handle()
    {
        // نتأكد أولاً من وجود إعدادات التحليلات
        $settings = AnalyticsSetting::getSettings();

        $this->info('جاري إنشاء بيانات تجريبية لنظام التحليلات...');

        try {
            $faker = Faker::create('ar_SA');
            $count = (int) $this->argument('count');

            $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera', 'Other'];
            $deviceTypes = ['desktop', 'mobile', 'tablet'];
            $operatingSystems = ['Windows', 'macOS', 'Linux', 'Android', 'iOS'];
            $countries = ['السعودية', 'مصر', 'الإمارات', 'الكويت', 'البحرين', 'قطر', 'عمان', 'الأردن', 'المغرب', 'تونس', 'الجزائر', 'العراق'];
            $cities = ['الرياض', 'جدة', 'دبي', 'القاهرة', 'الإسكندرية', 'الكويت', 'المنامة', 'الدوحة', 'مسقط', 'عمّان', 'الرباط', 'تونس', 'الجزائر', 'بغداد'];

            $this->output->progressStart($count);

            // URL الصفحات المحتملة
            $pageUrls = [
                'http://127.0.0.1:8000/' => 'الصفحة الرئيسية',
                'http://127.0.0.1:8000/about' => 'من نحن',
                'http://127.0.0.1:8000/services' => 'خدماتنا',
                'http://127.0.0.1:8000/blog' => 'المدونة',
                'http://127.0.0.1:8000/blog/category/technology' => 'تكنولوجيا - المدونة',
                'http://127.0.0.1:8000/contact' => 'اتصل بنا',
                'http://127.0.0.1:8000/pricing' => 'الأسعار',
                'http://127.0.0.1:8000/faqs' => 'الأسئلة الشائعة'
            ];

            $referrerUrls = [
                'https://www.google.com',
                'https://www.facebook.com',
                'https://twitter.com',
                'https://www.instagram.com',
                'https://www.linkedin.com',
                null, // مباشر (بدون مصدر إحالة)
            ];

            // الفترة الزمنية: آخر 30 يوم
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();

            for ($i = 0; $i < $count; $i++) {
                $randomPageKey = array_rand($pageUrls);
                $pageUrl = $randomPageKey;
                $pageTitle = $pageUrls[$randomPageKey];

                $createdAt = Carbon::createFromTimestamp(
                    rand($startDate->timestamp, $endDate->timestamp)
                );

                // زيادة عدد زيارات الصفحة الرئيسية
                if (rand(1, 100) <= 60 && isset($pageUrls['http://127.0.0.1:8000/'])) {
                    $pageUrl = 'http://127.0.0.1:8000/';
                    $pageTitle = $pageUrls['http://127.0.0.1:8000/'];
                }

                $isBounce = rand(0, 100) < 60; // 60% من الزيارات ترتد

                // إنشاء سجل زيارة جديد
                VisitorAnalytic::create([
                    'ip_address' => $faker->ipv4,
                    'user_agent' => $faker->userAgent,
                    'country' => $countries[array_rand($countries)],
                    'city' => $cities[array_rand($cities)],
                    'page_url' => $pageUrl,
                    'page_title' => $pageTitle,
                    'referrer_url' => $referrerUrls[array_rand($referrerUrls)],
                    'device_type' => $deviceTypes[array_rand($deviceTypes)],
                    'browser' => $browsers[array_rand($browsers)],
                    'os' => $operatingSystems[array_rand($operatingSystems)],
                    'is_unique' => rand(0, 100) < 70, // 70% فرصة أن تكون الزيارة فريدة
                    'is_bounce' => $isBounce,
                    'visit_duration' => $isBounce ? 0 : rand(10, 300), // 0 ثانية للزيارات المرتدة، وبين 10 و 300 ثانية للأخرى
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt
                ]);

                $this->output->progressAdvance();
            }

            $this->output->progressFinish();
            $this->info("تم إنشاء {$count} زيارة تجريبية بنجاح.");
            Log::info("تم إنشاء {$count} سجل زيارة تجريبي من خلال الأمر analytics:generate-data");
        } catch (\Exception $e) {
            $this->error("حدث خطأ أثناء إنشاء البيانات: " . $e->getMessage());
            Log::error("خطأ في أمر إنشاء بيانات التحليلات: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
}
