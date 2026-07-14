<?php

use App\Http\Controllers\Web\Admin;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Provider;
use App\Http\Controllers\Web\Site;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website — Section 8 of the spec
|--------------------------------------------------------------------------
*/
Route::get('/', [Site\HomeController::class, 'index'])->name('home');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }

    return back();
})->name('lang.switch');

Route::get('/properties', [Site\PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [Site\PropertyController::class, 'show'])->name('properties.show');

Route::get('/cities', [Site\CityController::class, 'index'])->name('cities.index');
Route::get('/categories', [Site\CategoryController::class, 'index'])->name('categories.index');

Route::get('/providers', [Site\ProviderController::class, 'index'])->name('providers.index');
Route::get('/providers/{serviceProvider}', [Site\ProviderController::class, 'show'])->name('providers.show');

Route::get('/pricing', [Site\PackageController::class, 'index'])->name('packages.index');

Route::get('/about', [Site\PageController::class, 'about'])->name('about');
Route::get('/contact', [Site\PageController::class, 'contact'])->name('contact');
Route::post('/contact', [Site\PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/faq', [Site\PageController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [Site\PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [Site\PageController::class, 'terms'])->name('terms');

Route::get('/register', [Site\RegisterController::class, 'create'])->name('register');
Route::post('/register', [Site\RegisterController::class, 'store'])->name('register.store');
Route::get('/register/provider', [Site\RegisterController::class, 'createProvider'])->name('register.provider');
Route::post('/register/provider', [Site\RegisterController::class, 'storeProvider'])->name('register.provider.store');

Route::middleware('auth')->group(function () {
    Route::post('/properties/{property}/inquiries', [Site\PropertyController::class, 'storeInquiry'])->name('properties.inquiries.store');
    Route::post('/properties/{property}/viewing-requests', [Site\PropertyController::class, 'storeViewingRequest'])->name('properties.viewing-requests.store');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Service provider console — Blade + Alpine
|--------------------------------------------------------------------------
*/
Route::prefix('provider')->name('provider.')->middleware(['auth', 'role:service_provider'])->group(function () {
    Route::get('/dashboard', [Provider\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/properties', [Provider\PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [Provider\PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [Provider\PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [Provider\PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [Provider\PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [Provider\PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::post('/properties/{property}/submit', [Provider\PropertyController::class, 'submit'])->name('properties.submit');
    Route::post('/properties/{property}/pause', [Provider\PropertyController::class, 'pause'])->name('properties.pause');
    Route::post('/properties/{property}/close-deal', [Provider\PropertyController::class, 'closeDeal'])->name('properties.close-deal');

    Route::get('/inquiries', [Provider\InquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/inquiries/{inquiry}/respond', [Provider\InquiryController::class, 'respond'])->name('inquiries.respond');

    Route::get('/viewings', [Provider\ViewingController::class, 'index'])->name('viewings.index');
    Route::patch('/viewings/{viewingRequest}', [Provider\ViewingController::class, 'updateStatus'])->name('viewings.update');

    Route::get('/messages', [Provider\MessageController::class, 'index'])->name('messages');

    Route::get('/subscription', [Provider\SubscriptionController::class, 'index'])->name('subscription');
    Route::post('/subscription/subscribe', [Provider\SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');

    Route::get('/invoices', [Provider\InvoiceController::class, 'index'])->name('invoices.index');
    Route::post('/invoices/{invoice}/pay', [Provider\InvoiceController::class, 'pay'])->name('invoices.pay');

    Route::get('/commissions', [Provider\CommissionController::class, 'index'])->name('commissions');
    Route::get('/statistics', [Provider\StatisticsController::class, 'index'])->name('statistics');

    Route::get('/profile', [Provider\ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [Provider\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/employees', [Provider\EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [Provider\EmployeeController::class, 'store'])->name('employees.store');
    Route::delete('/employees/{employee}', [Provider\EmployeeController::class, 'destroy'])->name('employees.destroy');

    Route::get('/notifications', [Provider\NotificationController::class, 'index'])->name('notifications');
    Route::patch('/notifications', [Provider\NotificationController::class, 'update'])->name('notifications.update');

    Route::get('/settings', [Provider\AccountController::class, 'edit'])->name('settings');
    Route::patch('/settings', [Provider\AccountController::class, 'update'])->name('settings.update');
    Route::patch('/settings/password', [Provider\AccountController::class, 'updatePassword'])->name('settings.password');
});

/*
|--------------------------------------------------------------------------
| Admin console — Blade + Alpine
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/properties', [Admin\PropertyController::class, 'index'])->name('properties.index');
    Route::post('/properties/{property}/approve', [Admin\PropertyController::class, 'approve'])->name('properties.approve');
    Route::post('/properties/{property}/reject', [Admin\PropertyController::class, 'reject'])->name('properties.reject');
    Route::get('/properties/{property}/photos', [Admin\PropertyController::class, 'photos'])->name('properties.photos');
    Route::delete('/properties/{property}/photos/{image}', [Admin\PropertyController::class, 'destroyPhoto'])->name('properties.photos.destroy');

    Route::get('/taxonomy', [Admin\TaxonomyController::class, 'index'])->name('taxonomy');
    Route::post('/taxonomy/categories', [Admin\TaxonomyController::class, 'storeCategory'])->name('taxonomy.categories.store');
    Route::post('/taxonomy/types', [Admin\TaxonomyController::class, 'storeType'])->name('taxonomy.types.store');
    Route::post('/taxonomy/features', [Admin\TaxonomyController::class, 'storeFeature'])->name('taxonomy.features.store');

    Route::get('/geo', [Admin\GeoController::class, 'index'])->name('geo');
    Route::post('/geo/cities', [Admin\GeoController::class, 'storeCity'])->name('geo.cities.store');
    Route::post('/geo/districts', [Admin\GeoController::class, 'storeDistrict'])->name('geo.districts.store');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users');
    Route::post('/users/{user}/toggle', [Admin\UserController::class, 'toggleActive'])->name('users.toggle');

    Route::get('/providers', [Admin\ProviderController::class, 'index'])->name('providers.index');
    Route::post('/providers/{serviceProvider}/verify', [Admin\ProviderController::class, 'verify'])->name('providers.verify');
    Route::post('/providers/{serviceProvider}/reject', [Admin\ProviderController::class, 'reject'])->name('providers.reject');

    Route::get('/roles', [Admin\RoleController::class, 'index'])->name('roles');
    Route::post('/roles', [Admin\RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}/permissions', [Admin\RoleController::class, 'syncPermissions'])->name('roles.permissions');

    Route::get('/subscriptions', [Admin\SubscriptionController::class, 'index'])->name('subscriptions');
    Route::post('/subscriptions/packages', [Admin\SubscriptionController::class, 'storePackage'])->name('subscriptions.packages.store');

    Route::get('/payments', [Admin\PaymentController::class, 'index'])->name('payments');
    Route::post('/payments/{payment}/refund', [Admin\PaymentController::class, 'refund'])->name('payments.refund');

    Route::get('/commissions', [Admin\CommissionController::class, 'index'])->name('commissions');
    Route::post('/commissions/{commission}/mark-paid', [Admin\CommissionController::class, 'markPaid'])->name('commissions.mark-paid');

    Route::get('/viewing-requests', [Admin\ViewingRequestController::class, 'index'])->name('viewing-requests');

    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->name('reviews');
    Route::patch('/reviews/{review}/moderate', [Admin\ReviewController::class, 'moderate'])->name('reviews.moderate');
    Route::post('/reports/{report}/resolve', [Admin\ReviewController::class, 'resolve'])->name('reports.resolve');

    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications');
    Route::patch('/notifications/{notificationTemplate}', [Admin\NotificationController::class, 'update'])->name('notifications.update');

    Route::get('/cms', [Admin\CmsController::class, 'index'])->name('cms');
    Route::post('/cms/pages', [Admin\CmsController::class, 'storePage'])->name('cms.pages.store');
    Route::patch('/cms/pages/{page}', [Admin\CmsController::class, 'updatePage'])->name('cms.pages.update');
    Route::post('/cms/faqs', [Admin\CmsController::class, 'storeFaq'])->name('cms.faqs.store');

    Route::get('/activity', [Admin\ActivityController::class, 'index'])->name('activity');
    Route::get('/backups', [Admin\BackupController::class, 'index'])->name('backups');

    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings');
    Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});
