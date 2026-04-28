<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
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
use App\Http\Controllers\Admin\AiSettingController as AdminAiSettingController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\User\KostAlertController;
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
Route::post('/checkout/validate-voucher', [CheckoutController::class , 'validateVoucher'])->name('checkout.validateVoucher');
Route::get('/checkout/{kostSlug}', [CheckoutController::class , 'show'])->name('checkout.show');
Route::post('/checkout/{kostSlug}', [CheckoutController::class , 'process'])->name('checkout.process');
Route::post('/payment/callback', [CheckoutController::class , 'callback'])->name('payment.callback');
Route::get('/success/{invoiceNo}', [CheckoutController::class , 'success'])->name('checkout.success');
Route::get('/checkout/status/{invoiceNo}', [CheckoutController::class , 'checkStatus'])->name('checkout.status');

// AI Consultation
Route::get('/konsultasi', [ChatController::class , 'index'])->name('chat.index');

// Static Pages & Forms
Route::get('/kontak', [ContactController::class , 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class , 'store'])->name('contact.store');
Route::get('/tentang', [PageController::class , 'tentang'])->name('tentang');
Route::get('/blog', [BlogController::class , 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class , 'show'])->name('blog.show');
Route::get('/terms-of-service', [PageController::class , 'tos'])->name('tos');
Route::get('/kebijakan-privasi', [PageController::class , 'privacy'])->name('privacy');
Route::get('/kebijakan-pengembalian-dana', [PageController::class , 'refund'])->name('refund');

// Auth Routes
Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class , 'login']);
Route::post('/logout', [LoginController::class , 'logout'])->name('logout');
Route::post('/forgot-password', [LoginController::class , 'forgotPassword'])->name('forgot-password');
Route::post('/otp/send', [LoginController::class , 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [LoginController::class , 'verifyOtp'])->name('otp.verify');

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
    Route::get('/alerts', [KostAlertController::class , 'index'])->name('alerts');
    Route::post('/alerts', [KostAlertController::class , 'store'])->name('alerts.store');
    Route::patch('/alerts/{id}/toggle', [KostAlertController::class , 'toggle'])->name('alerts.toggle');
    Route::delete('/alerts/{id}', [KostAlertController::class , 'destroy'])->name('alerts.destroy');
});

// Admin Panel
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class , 'chartData'])->name('dashboard.chartData');
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
    Route::resource('team', AdminTeamController::class)->except(['show', 'create']);
    Route::resource('vouchers', AdminVoucherController::class)->except(['show', 'create']);
    Route::resource('articles', AdminArticleController::class)->except(['show']);
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
    Route::get('settings/watermark/image-ids', [AdminSettingController::class , 'watermarkImageIds'])->name('settings.watermark.image-ids');
    Route::post('settings/watermark/apply-batch', [AdminSettingController::class , 'watermarkApplyBatch'])->name('settings.watermark.apply-batch');

    // AI Chat Settings
    Route::get('settings/alerts', [AdminSettingController::class , 'alerts'])->name('settings.alerts');
    Route::put('settings/alerts', [AdminSettingController::class , 'updateAlerts'])->name('settings.alerts.update');
    Route::post('settings/alerts/test', [AdminSettingController::class , 'testAlert'])->name('settings.alerts.test');
    Route::post('settings/alerts/send-now', [AdminSettingController::class , 'sendAlertsNow'])->name('settings.alerts.send-now');

    Route::get('settings/ai', [AdminAiSettingController::class , 'show'])->name('settings.ai');
    Route::put('settings/ai', [AdminAiSettingController::class , 'update'])->name('settings.ai.update');
    Route::post('settings/ai/test', [AdminAiSettingController::class , 'test'])->name('settings.ai.test');
    Route::post('settings/ai/clear-cache', [AdminAiSettingController::class , 'clearCache'])->name('settings.ai.clearCache');
});
