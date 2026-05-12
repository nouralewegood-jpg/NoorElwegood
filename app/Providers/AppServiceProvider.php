<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تعيين ترميز قاعدة البيانات لدعم الحروف العربية
        DB::statement('SET NAMES utf8mb4');
        DB::statement('SET CHARACTER SET utf8mb4');
        DB::statement('SET SESSION collation_connection = utf8mb4_unicode_ci');

        // تعيين ترميز PDO الافتراضي
        DB::getPdo()->exec("SET NAMES utf8mb4");

        // استخدام Bootstrap لصفحات الترقيم
        Paginator::useBootstrap();

        // تعيين الحد الأقصى المسموح به لطول السلسلة النصية في قاعدة البيانات
        Builder::defaultStringLength(191);
    }
}
