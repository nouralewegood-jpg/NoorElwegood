<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index']);

Route::get('/clearcache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('optimize:clear');
    $exitCode = Artisan::call('storage:link');
    // $exitCode = Artisan::call('optimize');
    return 'DONE';
});

// مسار لإنشاء رابط التخزين (storage link) دون استخدام سطر الأوامر
Route::get('/storage-link', function () {
    try {
        $exitCode = Artisan::call('storage:link');

        $response = [
            'success' => true,
            'message' => 'تم إنشاء رابط التخزين (storage link) بنجاح!',
            'exit_code' => $exitCode
        ];

        // تحقق من وجود الرابط الرمزي
        $linkExists = file_exists(public_path('storage'));
        $targetPath = $linkExists && is_link(public_path('storage')) ? readlink(public_path('storage')) : 'غير موجود';

        $response['details'] = [
            'link_exists' => $linkExists ? 'نعم' : 'لا',
            'link_path' => public_path('storage'),
            'target_path' => $targetPath
        ];

        return response()->json($response);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ أثناء إنشاء رابط التخزين: ' . $e->getMessage(),
            'error' => $e->getMessage()
        ], 500);
    }
})->middleware('admin'); // تقييد الوصول للمسؤولين فقط

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [App\Http\Controllers\MessageController::class, 'showContactForm'])->name('contact');
Route::get('/service/{slug}', [HomeController::class, 'serviceDetails'])->name('service.details');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page');
Route::get('/privacy-policy', [\App\Http\Controllers\PrivacyPolicyController::class, 'show'])->name('privacy.policy');
Route::get('/terms-of-service', [\App\Http\Controllers\TermsOfServiceController::class, 'show'])->name('terms.of.service');

// مسارات المدونة للواجهة الأمامية
Route::prefix('blog')->group(function () {
    Route::get('/', [App\Http\Controllers\Blog\BlogController::class, 'index'])->name('blog.index');
    Route::get('/search', [App\Http\Controllers\Blog\BlogController::class, 'search'])->name('blog.search');
    Route::get('/category/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'category'])->name('blog.category');
    Route::get('/tag/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'tag'])->name('blog.tag');
    Route::get('/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'show'])->name('blog.show');

    // إضافة دعم لطريقة POST للمقالات والوسوم
    Route::post('/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'handlePostRequest'])->name('blog.post');
    Route::post('/tag/{slug}', [App\Http\Controllers\Blog\BlogController::class, 'handleTagPostRequest'])->name('blog.tag.post');
});

// مسارات معرض الأعمال للواجهة الأمامية
Route::prefix('portfolio')->group(function () {
    Route::get('/', [App\Http\Controllers\Front\PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/{id}', [App\Http\Controllers\Front\PortfolioController::class, 'show'])->name('portfolio.show');
});

// استقبال الرسائل من نموذج الاتصال مع تطبيق محدد معدل الإرسال
Route::post('/send-message', [App\Http\Controllers\MessageController::class, 'store'])
    ->middleware('message.limit')
    ->name('message.send');

// مسار لحفظ طلبات الباقات/الخطط
Route::post('/submit-plan-request', [App\Http\Controllers\PlanRequestController::class, 'store'])
    ->name('plan.request.submit');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');

    // Profile Management Routes
    Route::post('/profile/update-info', [AdminController::class, 'updateProfileInfo'])->name('admin.profile.update-info');
    Route::post('/profile/update-password', [AdminController::class, 'updatePassword'])->name('admin.profile.update-password');
    Route::post('/profile/update-image', [AdminController::class, 'updateProfileImage'])->name('admin.profile.update-image');
    Route::post('/profile/update-logo', [AdminController::class, 'updateDashboardLogo'])->name('admin.profile.update-logo');

    // Privacy Policy Management
    Route::get('privacy-policy', [App\Http\Controllers\Admin\PrivacyPolicyController::class, 'index'])->name('admin.privacy-policy.index');
    Route::get('privacy-policy/{id}/edit', [App\Http\Controllers\Admin\PrivacyPolicyController::class, 'edit'])->name('admin.privacy-policy.edit');
    Route::put('privacy-policy/{id}', [App\Http\Controllers\Admin\PrivacyPolicyController::class, 'update'])->name('admin.privacy-policy.update');

    // Terms Of Service Management
    Route::get('terms-of-service', [App\Http\Controllers\Admin\TermsOfServiceController::class, 'index'])->name('admin.terms-of-service.index');
    Route::get('terms-of-service/{id}/edit', [App\Http\Controllers\Admin\TermsOfServiceController::class, 'edit'])->name('admin.terms-of-service.edit');
    Route::put('terms-of-service/{id}', [App\Http\Controllers\Admin\TermsOfServiceController::class, 'update'])->name('admin.terms-of-service.update');

    // Image Upload
    Route::post('upload/image', [App\Http\Controllers\Admin\ImageUploadController::class, 'upload'])->name('admin.upload.image');

    // Pages Management
    Route::resource('pages', PageController::class, ['as' => 'admin']);

    // تحليلات الزيارات
    Route::prefix('analytics')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics');
        Route::get('/settings', [App\Http\Controllers\Admin\AnalyticsController::class, 'settings'])->name('admin.analytics.settings');
        Route::post('/settings', [App\Http\Controllers\Admin\AnalyticsController::class, 'updateSettings'])->name('admin.analytics.settings.update');
        Route::post('/export-csv', [App\Http\Controllers\Admin\AnalyticsController::class, 'exportCsv'])->name('admin.analytics.export');
        Route::post('/clear-data', [App\Http\Controllers\Admin\AnalyticsController::class, 'clearAllData'])->name('admin.analytics.clear');
    });

    // Services Management
    Route::resource('services', ServiceController::class, ['as' => 'admin']);

    // Home Section Management
    Route::resource('home-section', \App\Http\Controllers\Admin\HomeSectionController::class, ['as' => 'admin']);
    Route::post('home-section/stats', [\App\Http\Controllers\Admin\HomeSectionController::class, 'storeStat'])->name('admin.home-section.stats.store');
    Route::put('home-section/stats/{stat}', [\App\Http\Controllers\Admin\HomeSectionController::class, 'updateStat'])->name('admin.home-section.stats.update');
    Route::delete('home-section/stats/{stat}', [\App\Http\Controllers\Admin\HomeSectionController::class, 'destroyStat'])->name('admin.home-section.stats.destroy');
    Route::post('home-section/stats/order', [\App\Http\Controllers\Admin\HomeSectionController::class, 'updateStatsOrder'])->name('admin.home-section.stats.order');

    // About Section Management
    Route::resource('about-section', \App\Http\Controllers\Admin\AboutSectionController::class, ['as' => 'admin']);
    Route::post('about-section/features', [\App\Http\Controllers\Admin\AboutSectionController::class, 'storeFeature'])->name('admin.about-section.features.store');
    Route::put('about-section/features/{feature}', [\App\Http\Controllers\Admin\AboutSectionController::class, 'updateFeature'])->name('admin.about-section.features.update');
    Route::delete('about-section/features/{feature}', [\App\Http\Controllers\Admin\AboutSectionController::class, 'destroyFeature'])->name('admin.about-section.features.destroy');
    Route::post('about-section/features/order', [\App\Http\Controllers\Admin\AboutSectionController::class, 'updateFeaturesOrder'])->name('admin.about-section.features.order');

    // Feature Section Management
    Route::resource('feature-section', \App\Http\Controllers\Admin\FeatureSectionController::class, ['as' => 'admin']);
    Route::post('feature-section/items', [\App\Http\Controllers\Admin\FeatureSectionController::class, 'storeItem'])->name('admin.feature-section.items.store');
    Route::put('feature-section/items/{item}', [\App\Http\Controllers\Admin\FeatureSectionController::class, 'updateItem'])->name('admin.feature-section.items.update');
    Route::delete('feature-section/items/{item}', [\App\Http\Controllers\Admin\FeatureSectionController::class, 'destroyItem'])->name('admin.feature-section.items.destroy');
    Route::post('feature-section/items/order', [\App\Http\Controllers\Admin\FeatureSectionController::class, 'updateItemsOrder'])->name('admin.feature-section.items.order');

    // Service Section Management
    Route::resource('service-section', \App\Http\Controllers\Admin\ServiceSectionController::class, ['as' => 'admin']);
    Route::post('service-section/items', [\App\Http\Controllers\Admin\ServiceSectionController::class, 'storeItem'])->name('admin.service-section.items.store');
    Route::get('service-section/items/{item}', [\App\Http\Controllers\Admin\ServiceSectionController::class, 'showItem'])->name('admin.service-section.items.show');
    Route::put('service-section/items/{item}', [\App\Http\Controllers\Admin\ServiceSectionController::class, 'updateItem'])->name('admin.service-section.items.update');
    Route::delete('service-section/items/{item}', [\App\Http\Controllers\Admin\ServiceSectionController::class, 'destroyItem'])->name('admin.service-section.items.destroy');
    Route::post('service-section/items/order', [\App\Http\Controllers\Admin\ServiceSectionController::class, 'updateItemsOrder'])->name('admin.service-section.items.order');

    // Pricing Section Management
    Route::resource('pricing-section', \App\Http\Controllers\Admin\PricingSectionController::class, ['as' => 'admin']);
    Route::post('pricing-section/plans', [\App\Http\Controllers\Admin\PricingSectionController::class, 'storePlan'])->name('admin.pricing-section.plans.store');
    Route::get('pricing-section/plans/{plan}', [\App\Http\Controllers\Admin\PricingSectionController::class, 'showPlan'])->name('admin.pricing-section.plans.show');
    Route::put('pricing-section/plans/{plan}', [\App\Http\Controllers\Admin\PricingSectionController::class, 'updatePlan'])->name('admin.pricing-section.plans.update');
    Route::delete('pricing-section/plans/{plan}', [\App\Http\Controllers\Admin\PricingSectionController::class, 'destroyPlan'])->name('admin.pricing-section.plans.destroy');
    Route::post('pricing-section/plans/order', [\App\Http\Controllers\Admin\PricingSectionController::class, 'updatePlansOrder'])->name('admin.pricing-section.plans.order');

    Route::post('pricing-section/plans/{plan}/features', [\App\Http\Controllers\Admin\PricingSectionController::class, 'storePlanFeature'])->name('admin.pricing-section.plans.features.store');
    Route::put('pricing-section/plans/{plan}/features/{feature}', [\App\Http\Controllers\Admin\PricingSectionController::class, 'updatePlanFeature'])->name('admin.pricing-section.plans.features.update');
    Route::delete('pricing-section/plans/{plan}/features/{feature}', [\App\Http\Controllers\Admin\PricingSectionController::class, 'destroyPlanFeature'])->name('admin.pricing-section.plans.features.destroy');
    Route::post('pricing-section/plans/{plan}/features/order', [\App\Http\Controllers\Admin\PricingSectionController::class, 'updatePlanFeaturesOrder'])->name('admin.pricing-section.plans.features.order');

    // Contact Section Management
    Route::resource('contact-section', \App\Http\Controllers\Admin\ContactSectionController::class, ['as' => 'admin']);

    // إدارة الرسائل
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('admin.messages.index');
    Route::get('/messages/{id}', [\App\Http\Controllers\MessageController::class, 'show'])->name('admin.messages.show');
    Route::delete('/messages/{id}', [\App\Http\Controllers\MessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::post('/messages/bulk-update', [\App\Http\Controllers\MessageController::class, 'bulkUpdate'])->name('admin.messages.bulk-update');
    // واجهات برمجة تطبيقات الرسائل للتحديث التلقائي
    Route::get('/messages/get-latest', [\App\Http\Controllers\MessageController::class, 'getLatest'])->name('admin.messages.get-latest');
    Route::post('/messages/mark-all-read', [\App\Http\Controllers\MessageController::class, 'markAllRead'])->name('admin.messages.mark-all-read');

    // إدارة الإشعارات
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications');
    Route::get('/notifications/get-latest', [\App\Http\Controllers\Admin\NotificationController::class, 'getLatest'])->name('admin.notifications.get-latest');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('admin.notifications.mark-all-read');

    // Icons Library
    Route::get('/icons', [\App\Http\Controllers\Admin\IconsController::class, 'index'])->name('admin.icons.index');

    // Chatbot Settings Management
    Route::resource('chatbot-settings', \App\Http\Controllers\Admin\ChatbotSettingController::class, ['as' => 'admin']);
    Route::get('chatbot-settings-export', [\App\Http\Controllers\Admin\ChatbotSettingController::class, 'export'])->name('admin.chatbot-settings.export');
    Route::get('chatbot-settings-import', [\App\Http\Controllers\Admin\ChatbotSettingController::class, 'showImport'])->name('admin.chatbot-settings.showImport');
    Route::post('chatbot-settings-import', [\App\Http\Controllers\Admin\ChatbotSettingController::class, 'import'])->name('admin.chatbot-settings.import');
    Route::get('chatbot-settings-template', [\App\Http\Controllers\Admin\ChatbotSettingController::class, 'downloadTemplate'])->name('admin.chatbot-settings.template');

    // Chatbot Synonyms Management
    Route::resource('chatbot-synonyms', \App\Http\Controllers\Admin\ChatbotSynonymController::class, ['as' => 'admin']);

    // إدارة المدونة
    Route::prefix('blog')->name('admin.blog.')->group(function () {
        // إدارة المقالات
        Route::resource('posts', \App\Http\Controllers\Admin\BlogPostController::class);

        // إدارة التصنيفات
        Route::resource('categories', \App\Http\Controllers\Admin\BlogCategoryController::class);

        // إدارة الوسوم
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
    });

    // إدارة طلبات الخطط
    Route::prefix('plan-requests')->name('admin.plan-requests.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PlanRequestController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\Admin\PlanRequestController::class, 'show'])->name('show');
        Route::put('/{id}', [App\Http\Controllers\Admin\PlanRequestController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\PlanRequestController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-update', [App\Http\Controllers\Admin\PlanRequestController::class, 'bulkUpdate'])->name('bulk-update');
    });

    Route::resource('testimonials', TestimonialController::class, ['as' => 'admin']);

    // إضافة مسارات إدارة الأسئلة غير المجاب عنها
    Route::prefix('chatbot-questions')->name('admin.chatbot-questions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ChatbotUnansweredQuestionController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\ChatbotUnansweredQuestionController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\ChatbotUnansweredQuestionController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\Admin\ChatbotUnansweredQuestionController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/transfer', [App\Http\Controllers\Admin\ChatbotUnansweredQuestionController::class, 'transfer'])->name('transfer');
        Route::post('/bulk-transfer', [App\Http\Controllers\Admin\ChatbotUnansweredQuestionController::class, 'bulkTransfer'])->name('bulk-transfer');
    });

    // إدارة معرض الأعمال
    Route::prefix('portfolio')->name('admin.portfolio.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PortfolioController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\PortfolioController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\PortfolioController::class, 'store'])->name('store');
        Route::get('/{portfolio}', [App\Http\Controllers\Admin\PortfolioController::class, 'show'])->name('show');
        Route::get('/{portfolio}/edit', [App\Http\Controllers\Admin\PortfolioController::class, 'edit'])->name('edit');
        Route::put('/{portfolio}', [App\Http\Controllers\Admin\PortfolioController::class, 'update'])->name('update');
        Route::delete('/{portfolio}', [App\Http\Controllers\Admin\PortfolioController::class, 'destroy'])->name('destroy');
        Route::post('/order', [App\Http\Controllers\Admin\PortfolioController::class, 'order'])->name('order');
    });

    Route::get('/{page}', [AdminController::class, 'viewPage'])->name('admin.page');
});

// Moderator Routes
Route::prefix('moderator')->middleware('moderator')->group(function () {
    Route::get('/dashboard', [ModeratorController::class, 'dashboard'])->name('moderator.dashboard');
    Route::get('/profile', [ModeratorController::class, 'profile'])->name('moderator.profile');
    Route::get('/{page}', [ModeratorController::class, 'viewPage'])->name('moderator.page');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Newsletter subscription
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'store'])
    ->name('newsletter.subscribe');
