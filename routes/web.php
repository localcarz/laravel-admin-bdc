<?php

use App\Http\Controllers\Admin\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CacheCommandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\Authcontroller;

Route::get('/', function () {
    // return view('Auth.login');
    return redirect()->route('admin.login');
});


// Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


// Route::get('admin/login',[LoginController::class,'index'])->name('admin.login');
// Route::post('admin/login',[LoginController::class,'login'])->name('admin.login.submit');
// Route::get('admin/logout',[LoginController::class,'logout'])->name('admin.logout');
// Route::get('admin/register',[RegisterController::class,'index'])->name('admin.register');
// Route::post('admin/register',[RegisterController::class,'register'])->name('admin.register.submit');
// Route::get('admin/forgot-password',[ForgotPasswordController::class,'index'])->name('admin.forgot.password');
// Route::post('admin/forgot-password',[ForgotPasswordController::class,'sendResetLink'])->name('admin.forgot.password.submit');
// Route::get('admin/reset-password/{token}',[ResetPasswordController::class,'index'])->name('admin.reset.password');
// Route::post('admin/reset-password',[ResetPasswordController::class,'reset'])->name('admin.reset.password.submit');
// Route::get('admin/profile',[ProfileController::class,'index'])->name('admin.profile');
// Route::post('admin/profile',[ProfileController::class,'update'])->name('admin.profile.update');
// Route::get('admin/change-password',[ChangePasswordController::class,'index'])->name('admin.change.password');
// Route::post('admin/change-password',[ChangePasswordController::class,'update'])->name('admin.change.password.update');

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', [Authcontroller::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth.admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('blank', [DashboardController::class, 'blank'])->name('blank');

        Route::group(['prefix' => 'inventory', 'as' => 'inventory.'], function () {
            Route::get('/', [InventoryController::class, 'index'])->name('index');
            Route::get('/create', [InventoryController::class, 'create'])->name('create');
            Route::post('/', [InventoryController::class, 'store'])->name('store');
            Route::get('/{id}', [InventoryController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [InventoryController::class, 'update'])->name('update');
            Route::post('/{id}/status', [InventoryController::class, 'status'])->name('status');
            Route::delete('/{id}', [InventoryController::class, 'destroy'])->name('destroy');
        });

        // Route::get('inventories', [InventoryController::class, 'index'])->name('inventory');

        Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
        Route::put('blog/update', [BlogController::class, 'update'])->name('blog.update');
        Route::post('blog/status', [BlogController::class, 'status'])->name('blog.status');
        Route::get('blog/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::get('blog/show', [BlogController::class, 'show'])->name('blog.show');
        Route::delete('blog/destroy', [BlogController::class, 'destroy'])->name('blog.destroy');

        Route::get('auto-news', [BlogController::class, 'autoNews'])->name('autoNews');
        Route::get('reviews', [BlogController::class, 'reviews'])->name('reviews');
        Route::get('tools-and-advice', [BlogController::class, 'toolsAndAdvice'])->name('toolsAndAdvice');
        Route::get('car-buying-advice', [BlogController::class, 'carBuyingAdvice'])->name('carBuyingAdvice');
        Route::get('car-tips', [BlogController::class, 'carTips'])->name('carTips');

        Route::get('news', [BlogController::class, 'news'])->name('news');
        Route::get('innovation', [BlogController::class, 'innovation'])->name('innovation');
        Route::get('opinion', [BlogController::class, 'opinion'])->name('opinion');
        Route::get('financial', [BlogController::class, 'financial'])->name('financial');

        Route::get('banner', [BannerController::class, 'index'])->name('banner');
        Route::get('dealer/profile', [DealerController::class, 'index'])->name('dealer.profile');

        Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
            // Route::get('/', [BannerController::class, 'index'])->name('banner');
            Route::post('/', [BannerController::class, 'store'])->name('store');
            Route::get('/show', [BannerController::class, 'show'])->name('show');
            Route::get('/edit', [BannerController::class, 'edit'])->name('edit');
            Route::get('/link', [BannerController::class, 'link'])->name('link');
            Route::put('/link/update', [BannerController::class, 'linkUpdate'])->name('link.update');
            Route::post('/status', [BannerController::class, 'status'])->name('status');
            Route::put('/update', [BannerController::class, 'update'])->name('update');
            Route::delete('/destroy', [BannerController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'lead', 'as' => 'lead.'], function () {
            Route::get('/', [LeadController::class, 'index'])->name('index');
        });

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/general', [SettingsController::class, 'index'])->name('general');
            Route::get('/edit', [SettingsController::class, 'edit'])->name('edit');
            Route::post('/update', [SettingsController::class, 'update'])->name('update');

            // Route::get('image/get', [SettingsController::class, 'identify'])->name('image.get');
            // Route::post('add', [SettingsController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'lead', 'as' => 'lead.'], function () {
            Route::get('/', [LeadController::class, 'index'])->name('index');
        });

        Route::resource('cache-commands', CacheCommandController::class);
        Route::post('cache-commands/run/{id}', [CacheCommandController::class, 'runSingle'])->name('api.cache-commands.run');
        Route::post('cache-commands/{id}/delete-cache', [CacheCommandController::class, 'deleteCache'])->name('api.cache-commands.delete-cache');

        Route::group(['prefix' => 'cache-commands', 'as' => 'cache-commands.'], function () {
            Route::delete('/delete/{id}', [CacheCommandController::class, 'destroy'])->name('delete');
            Route::post('/status', [CacheCommandController::class, 'status'])->name('status');
            Route::get('/run/{command}', [CacheCommandController::class, 'runCommand'])->name('run');
            Route::post('/run-all', [CacheCommandController::class, 'runAll'])->name('run-all');
            Route::post('/delete-all', [CacheCommandController::class, 'deleteAll'])->name('delete-all');
        });

    });
});



    // Route::post('cache-commands/run-all', [CacheCommandController::class, 'runAll'])->name('cache-commands.run-all');
    // Route::post('cache-commands/{id}/delete-cache', [CacheCommandController::class, 'deleteCache'])->name('cache-commands.delete-cache');
    // Route::get('cache-commands/show', [CacheCommandController::class, 'singleCacheCommands'])->name('single.cache.view');
