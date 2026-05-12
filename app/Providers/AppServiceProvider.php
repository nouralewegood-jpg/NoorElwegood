<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            if (DB::getDriverName() === 'mysql') {
                DB::statement('SET NAMES utf8mb4');
                DB::statement('SET CHARACTER SET utf8mb4');
                DB::statement('SET SESSION collation_connection = utf8mb4_unicode_ci');
                DB::getPdo()->exec("SET NAMES utf8mb4");
            }
        } catch (\Exception $e) {
            //
        }

        Paginator::useBootstrap();
        Builder::defaultStringLength(191);
    }
}
