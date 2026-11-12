<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenHubController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CabinetController;

Route::get('/', [TokenHubController::class, 'home'])->name('home');
Route::get('/models', [TokenHubController::class, 'models'])->name('models');
Route::get('/login', fn () => redirect()->route('cabinet.login'))->name('login');
Route::get('/register', [TokenHubController::class, 'register'])->name('register');
Route::post('/register', [TokenHubController::class, 'storeUser']);
Route::post('/logout', [TokenHubController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/cabinet/login', [CabinetController::class, 'login'])->name('cabinet.login');
Route::post('/cabinet/login', [CabinetController::class, 'authenticate'])->name('cabinet.login.submit');
Route::post('/cabinet/login-key', [CabinetController::class, 'loginByKey'])->name('cabinet.login.key');
Route::post('/cabinet/logout', [CabinetController::class, 'logout'])->middleware('auth')->name('cabinet.logout');

Route::middleware('auth')->group(function () {
    Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet');
    Route::get('/dashboard', fn () => redirect()->route('cabinet'))->name('dashboard');
    Route::post('/cabinet/keys', [CabinetController::class, 'createKey'])->name('cabinet.keys.create');
    Route::delete('/cabinet/keys/{key}', [CabinetController::class, 'deleteKey'])->name('cabinet.keys.delete');
    Route::post('/cabinet/topup', [CabinetController::class, 'topup'])->name('cabinet.topup');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('admin.logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('admin.users.show');
    Route::post('/users/{user}/toggle-admin', [AdminController::class, 'userToggleAdmin'])->name('admin.users.toggle');
    Route::post('/users/{user}/adjust', [AdminController::class, 'userAdjust'])->name('admin.users.adjust');

    Route::get('/keys', [AdminController::class, 'keys'])->name('admin.keys');
    Route::delete('/keys/{key}', [AdminController::class, 'keyDelete'])->name('admin.keys.delete');

    Route::get('/models', [AdminController::class, 'models'])->name('admin.models');
    Route::patch('/models/{model}', [AdminController::class, 'updateModel'])->name('admin.models.update');
    Route::post('/models', [AdminController::class, 'createModel'])->name('admin.models.create');

    Route::get('/usage', [AdminController::class, 'usage'])->name('admin.usage');
    Route::get('/ledger', [AdminController::class, 'ledger'])->name('admin.ledger');

    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/payments/{order}/mark-paid', [AdminController::class, 'paymentMarkPaid'])->name('admin.payments.paid');

    Route::get('/gateways', [AdminController::class, 'gateways'])->name('admin.gateways');
    Route::patch('/gateways/{gateway}', [AdminController::class, 'gatewayUpdate'])->name('admin.gateways.update');

    Route::get('/webhooks', [AdminController::class, 'webhooks'])->name('admin.webhooks');

    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'settingsSave'])->name('admin.settings.save');
});
