<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Service;
use App\Services\SchemaService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // Default SEO settings
            $seo = [
                'title' => 'نور الوجود - الشركة الرائدة في خدمات الصيانة العامة والديكور',
                'description' => 'شركة نور الوجود هي شركة رائدة متخصصة في الصيانة العامة والديكور بما يشمل أعمال الدهانات، الجبس بورد، تركيب السيراميك، بديل الرخام والخشب، السباكة، الكهرباء، وتجارة الرخام في الإمارات العربية المتحدة',
                'og_image' => asset('assets-home/img/logo.png'),
                'twitter_card' => 'summary_large_image',
                'canonical' => url()->current(),
                'locale' => 'ar-EG',
                'alternate_locale' => 'en-US',
            ];

            // Default organization schema for all pages
            $schemas = [];
            $schemas[] = SchemaService::getOrganizationSchema();

            // Add specific schema based on route
            $routeName = Route::currentRouteName();
            $currentRoute = Route::current();

            if ($routeName === 'home') {
                // Add LocalBusiness schema for homepage
                $schemas[] = SchemaService::getLocalBusinessSchema();
            } elseif ($routeName === 'blog.show' && isset($view->getData()['post'])) {
                // Add article schema for blog posts
                $post = $view->getData()['post'];
                $schemas[] = SchemaService::getArticleSchema($post->toArray());
            } elseif ($routeName === 'services.show' && isset($view->getData()['service'])) {
                // Add service schema for service pages
                $service = $view->getData()['service'];
                $schemas[] = SchemaService::getServiceSchema([
                    'name' => $service->title,
                    'description' => $service->description,
                    'type' => $service->category ?? 'MaintenanceService'
                ]);
            }

            $seo['schemas'] = $schemas;
            $view->with('seo', $seo);
        });
    }
}
