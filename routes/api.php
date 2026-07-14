<?php

use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\PropertyApprovalController;
use App\Http\Controllers\Api\Admin\ServiceProviderVerificationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CmsPageController;
use App\Http\Controllers\Api\CommissionController;
use App\Http\Controllers\Api\DeviceTokenController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\GeoController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\NotificationTemplateController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PropertyCategoryController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\PropertyFeatureController;
use App\Http\Controllers\Api\PropertyReportController;
use App\Http\Controllers\Api\PropertyTypeController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ServiceProviderController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SubscriptionPackageController;
use App\Http\Controllers\Api\SystemSettingController;
use App\Http\Controllers\Api\ViewingRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes — website & unauthenticated browsing
|--------------------------------------------------------------------------
*/
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/register-provider', [AuthController::class, 'registerProvider']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property}', [PropertyController::class, 'show']);
Route::get('/property-categories', [PropertyCategoryController::class, 'index']);
Route::get('/property-types', [PropertyTypeController::class, 'index']);
Route::get('/property-features', [PropertyFeatureController::class, 'index']);
Route::get('/geo/countries', [GeoController::class, 'countries']);
Route::get('/geo/cities', [GeoController::class, 'cities']);
Route::get('/geo/cities/{city}/districts', [GeoController::class, 'districts']);
Route::get('/subscription-packages', [SubscriptionPackageController::class, 'index']);
Route::get('/providers', [ServiceProviderController::class, 'index']);
Route::get('/providers/{serviceProvider}', [ServiceProviderController::class, 'show']);
Route::get('/pages', [CmsPageController::class, 'index']);
Route::get('/pages/{slug}', [CmsPageController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Authenticated — shared across roles
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Customer actions
    Route::post('/properties/{property}/inquiries', [InquiryController::class, 'store']);
    Route::post('/properties/{property}/viewing-requests', [ViewingRequestController::class, 'store']);
    Route::post('/properties/{property}/reviews', [ReviewController::class, 'store']);
    Route::post('/properties/{property}/reports', [PropertyReportController::class, 'store']);
    Route::get('/my/viewing-requests', [ViewingRequestController::class, 'index']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/properties/{property}/favorite', [FavoriteController::class, 'toggle']);
    Route::post('/device-tokens', [DeviceTokenController::class, 'store']);
    Route::delete('/device-tokens', [DeviceTokenController::class, 'destroy']);

    /*
    |----------------------------------------------------------------
    | Service provider console
    |----------------------------------------------------------------
    */
    Route::prefix('provider')->middleware('role:service_provider')->group(function () {
        Route::get('/dashboard', [ServiceProviderController::class, 'dashboard']);
        Route::patch('/profile', [ServiceProviderController::class, 'updateProfile']);

        Route::get('/properties', [PropertyController::class, 'myProperties']);
        Route::post('/properties', [PropertyController::class, 'store']);
        Route::patch('/properties/{property}', [PropertyController::class, 'update']);
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy']);
        Route::post('/properties/{property}/submit', [PropertyController::class, 'submit']);
        Route::post('/properties/{property}/pause', [PropertyController::class, 'pause']);
        Route::post('/properties/{property}/close-deal', [PropertyController::class, 'markDealClosed']);

        Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::post('/invoices/{invoice}/pay', [PaymentController::class, 'pay']);
        Route::get('/commissions', [CommissionController::class, 'index']);

        Route::get('/inquiries', [InquiryController::class, 'index']);
        Route::post('/inquiries/{inquiry}/respond', [InquiryController::class, 'respond']);
        Route::get('/viewing-requests', [ViewingRequestController::class, 'index']);
        Route::patch('/viewing-requests/{viewingRequest}', [ViewingRequestController::class, 'updateStatus']);
    });

    /*
    |----------------------------------------------------------------
    | Admin console
    |----------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

        Route::get('/properties/pending', [PropertyApprovalController::class, 'pending']);
        Route::post('/properties/{property}/approve', [PropertyApprovalController::class, 'approve']);
        Route::post('/properties/{property}/reject', [PropertyApprovalController::class, 'reject']);

        Route::get('/providers/pending', [ServiceProviderVerificationController::class, 'pending']);
        Route::post('/providers/{serviceProvider}/verify', [ServiceProviderVerificationController::class, 'verify']);
        Route::post('/providers/{serviceProvider}/reject', [ServiceProviderVerificationController::class, 'reject']);

        Route::apiResource('property-categories', PropertyCategoryController::class)->except('index');
        Route::apiResource('property-types', PropertyTypeController::class)->except('index');
        Route::post('/geo/cities', [GeoController::class, 'storeCity']);
        Route::post('/geo/districts', [GeoController::class, 'storeDistrict']);

        Route::apiResource('subscription-packages', SubscriptionPackageController::class)->except('index');
        Route::get('/subscriptions', [SubscriptionController::class, 'index']);
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);
        Route::get('/payments', [PaymentController::class, 'index']);
        Route::post('/payments/{payment}/refund', [PaymentController::class, 'refund']);
        Route::get('/commissions', [CommissionController::class, 'index']);
        Route::post('/commissions/{commission}/mark-paid', [CommissionController::class, 'markPaid']);

        Route::get('/reviews', [ReviewController::class, 'index']);
        Route::patch('/reviews/{review}/moderate', [ReviewController::class, 'moderate']);
        Route::get('/reports', [PropertyReportController::class, 'index']);
        Route::post('/reports/{propertyReport}/resolve', [PropertyReportController::class, 'resolve']);

        Route::apiResource('cms-pages', CmsPageController::class)->except(['index', 'show']);
        Route::get('/notification-templates', [NotificationTemplateController::class, 'index']);
        Route::patch('/notification-templates/{notificationTemplate}', [NotificationTemplateController::class, 'update']);

        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::get('/permissions', [RoleController::class, 'permissions']);
        Route::put('/roles/{role}/permissions', [RoleController::class, 'syncPermissions']);

        Route::get('/settings', [SystemSettingController::class, 'index']);
        Route::put('/settings', [SystemSettingController::class, 'update']);
    });
});
