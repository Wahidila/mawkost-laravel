<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KostController as AdminKostController;
use App\Http\Controllers\Admin\KostTypeController as AdminKostTypeController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\User\UserDashboardController;

// Public Pages
Route::get('/', [HomeController::class , 'index'])->name('home');

// Storage fallback (for shared hosting where symlink doesn't work)
Route::get('/storage/{path}', [StorageController::class , 'serve'])->where('path', '.*')->name('storage.serve');
Route::get('/cari-kost', [KostController::class , 'search'])->name('kost.search');
Route::post('/kost/cari-kode', [KostController::class , 'searchByCode'])->name('kost.searchByCode');
Route::get('/kost/{citySlug}', [KostController::class , 'byCity'])->name('kost.byCity');
Route::get('/kost/{citySlug}/{slug}', [KostController::class , 'show'])->name('kost.show');

// Checkout
Route::get('/checkout/{kostSlug}', [CheckoutController::class , 'show'])->name('checkout.show');
Route::post('/checkout/{kostSlug}', [CheckoutController::class , 'process'])->name('checkout.process');
Route::post('/payment/callback', [CheckoutController::class , 'callback'])->name('payment.callback');
Route::get('/success/{invoiceNo}', [CheckoutController::class , 'success'])->name('checkout.success');
Route::get('/checkout/status/{invoiceNo}', [CheckoutController::class , 'checkStatus'])->name('checkout.status');

// Static Pages & Forms
Route::get('/kontak', [ContactController::class , 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class , 'store'])->name('contact.store');
Route::get('/tentang', [PageController::class , 'tentang'])->name('tentang');
Route::get('/terms-of-service', [PageController::class , 'tos'])->name('tos');
Route::get('/kebijakan-privasi', [PageController::class , 'privacy'])->name('privacy');
Route::get('/kebijakan-pengembalian-dana', [PageController::class , 'refund'])->name('refund');

// Auth Routes
Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class , 'login']);
Route::post('/logout', [LoginController::class , 'logout'])->name('logout');

// User Dashboard
Route::group(['prefix' => 'user', 'middleware' => 'auth', 'as' => 'user.'], function () {
    Route::get('/dashboard', [UserDashboardController::class , 'index'])->name('dashboard');
    Route::get('/orders', [UserDashboardController::class , 'orders'])->name('orders');
    Route::get('/orders/{id}', [UserDashboardController::class , 'showOrder'])->name('orders.show');
    Route::post('/orders/{id}/retry', [UserDashboardController::class , 'retryPayment'])->name('orders.retry');
    Route::get('/profile', [UserDashboardController::class , 'profile'])->name('profile');
    Route::put('/profile', [UserDashboardController::class , 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserDashboardController::class , 'updatePassword'])->name('profile.password');
    Route::delete('/profile/avatar', [UserDashboardController::class , 'deleteAvatar'])->name('profile.avatar.delete');
});

// Admin Panel
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::resource('kosts', AdminKostController::class);
    Route::patch('kosts/{kost}/toggle-featured', [AdminKostController::class , 'toggleFeatured'])->name('kosts.toggleFeatured');
    Route::patch('kosts/{kost}/toggle-recommended', [AdminKostController::class , 'toggleRecommended'])->name('kosts.toggleRecommended');
    Route::delete('kosts/{kost}/images/{image}', [AdminKostController::class , 'destroyImage'])->name('kosts.images.destroy');
    Route::resource('kost_types', AdminKostTypeController::class)->except(['show', 'create']);
    Route::resource('cities', AdminCityController::class);
    Route::resource('facilities', AdminFacilityController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/status', [AdminOrderController::class , 'updateStatus'])->name('orders.updateStatus');
    Route::get('orders-export', [AdminOrderController::class , 'export'])->name('orders.export');
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show']);
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/send-credentials', [AdminUserController::class , 'sendCredentials'])->name('users.sendCredentials');

    // WhatsApp Settings
    Route::get('settings/whatsapp', [AdminSettingController::class , 'whatsapp'])->name('settings.whatsapp');
    Route::put('settings/whatsapp', [AdminSettingController::class , 'updateWhatsapp'])->name('settings.whatsapp.update');
    Route::post('settings/whatsapp/test', [AdminSettingController::class , 'testWhatsapp'])->name('settings.whatsapp.test');

    // Xendit Settings
    Route::get('settings/xendit', [AdminSettingController::class , 'xendit'])->name('settings.xendit');
    Route::put('settings/xendit', [AdminSettingController::class , 'updateXendit'])->name('settings.xendit.update');
    Route::post('settings/xendit/test', [AdminSettingController::class , 'testXendit'])->name('settings.xendit.test');

    // Footer Settings
    Route::get('settings/footer', [AdminSettingController::class , 'footer'])->name('settings.footer');
    Route::put('settings/footer', [AdminSettingController::class , 'updateFooter'])->name('settings.footer.update');

    // Watermark Settings
    Route::get('settings/watermark', [AdminSettingController::class , 'watermark'])->name('settings.watermark');
    Route::put('settings/watermark', [AdminSettingController::class , 'updateWatermark'])->name('settings.watermark.update');
    Route::post('settings/watermark/apply-all', [AdminSettingController::class , 'applyWatermarkAll'])->name('settings.watermark.apply-all');
});
