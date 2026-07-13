<?php

use App\Http\Controllers\Web\Admin as Admin;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Provider as Provider;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
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
