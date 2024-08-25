<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Home\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\ContactFormController;
use App\Http\Controllers\Home\AnalyticsController;
use App\Http\Controllers\Maps\PointController;
use App\Http\Controllers\Modal\ComplementoController;
use App\Http\Controllers\Finance\SubscriptionController;
use App\Http\Controllers\Finance\PaymentController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');
Route::get('/', [AnalyticsController::class, 'track'])->name('home');
Route::post('/increment-clicks', [AnalyticsController::class, 'incrementClicks'])->name('increment-clicks');

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::post('/points', [PointController::class, 'store'])->name('points.store');
Route::get('/points', [PointController::class, 'loadUserPoints']);
Route::get('/highlighted-markers', [PointController::class, 'loadHighlightedMarkers']);
Route::post('/points/{id}/like', [PointController::class, 'like'])->name('points.like');
Route::get('/load-all-points', [PointController::class, 'loadAllPoints'])->name('points.loadAll');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['patch', 'put'], '/profile/manager/profile', [ProfileController::class, 'update'])->name('profile.manager.update-profile');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/register-profile', function () {
        $points = (new \App\Http\Controllers\Maps\PointController)->loadUserPoints();
        return view('profile.register-profile', compact('points'));
    })->name('auth.profile');
    
    // Rotas para produtos
    Route::get('/profile/manager/products', function () {return view('profile.manager.manager-products');})->name('profile.manager.products');
    Route::get('/profile/products/register', function () {return view('profile.products.register-products');})->name('profile.products.register');
    Route::get('/profile/products/edit/{id}', function ($id) {
        $points = (new \App\Http\Controllers\Maps\PointController)->loadUserPoints();
        return view('profile.products.edit-product', compact('id', 'points'));
    })->name('profile.products.edit');    
    Route::get('/profile/manager/point/edit/{id}', function ($id) {
        $points = (new \App\Http\Controllers\Maps\PointController)->loadUserPoints();
        return view('profile.manager.edit-point', compact('id', 'points'));
    })->name('profile.manager.edit-point');
    
    Route::get('/profile/manager/profile', function () {
        $points = (new \App\Http\Controllers\Maps\PointController)->loadUserPoints();
        return view('profile.manager.manager-profile', compact('points'));
    })->name('profile.manager.profile');
    
    Route::get('/profile/manager/products', [ProductController::class, 'index'])->name('profile.manager.products');
    Route::get('/profile/products/create', function () {
        $points = (new \App\Http\Controllers\Maps\PointController)->loadUserPoints();
        return view('profile.products.create', compact('points'));
    })->name('profile.products.create');

    // Rota para listar todos os complementos
    Route::get('/complementos', [ComplementoController::class, 'index'])->name('complementos.index');
    Route::get('/complementos/{id}', [ComplementoController::class, 'show'])->name('complementos.show');
    Route::post('/complementos', [ComplementoController::class, 'store'])->name('complementos.store');
    Route::put('/complemento/{id}', [ComplementoController::class, 'update'])->name('complemento.update');
    Route::match(['patch', 'post'], 'complementos/{id}/update-days-hours', [ComplementoController::class, 'updateDaysHours'])->name('complemento.updateDaysHours');
    Route::match(['patch', 'post'], '/complementos/{id}/update-attachments', [ComplementoController::class, 'updateAttachments'])->name('complemento.updateAttachments');
    Route::post('/complementos/{id}/images', [ComplementoController::class, 'addImages'])->name('complementos.addImages');
    Route::post('/complementos/{id}/videos', [ComplementoController::class, 'addVideos'])->name('complementos.addVideos');

    Route::post('/profile/products/store', [ProductController::class, 'store'])->name('profile.products.store');
    Route::get('profile/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::delete('profile/products/{product}', [ProductController::class, 'destroy'])->name('profile.products.destroy');
    Route::patch('/profile/products/{product}', [ProductController::class, 'update'])->name('profile.products.update');
    Route::get('/profile/products/{product}/edit', [ProductController::class, 'edit'])->name('profile.products.edit');

    Route::patch('/profile/manager/profile', [ProfileController::class, 'update'])->name('profile.manager.update-profile');
    Route::get('/profile/manager/point', function () {return view('profile.manager.manager-point');})->name('profile.manager.point');
    Route::get('/profile/manager/point', [PointController::class, 'index'])->name('profile.manager.point');
    Route::patch('/points/{point}', [PointController::class, 'update'])->name('points.update');
    Route::get('points/{point}/edit', [PointController::class, 'edit'])->name('points.edit');
    Route::get('/points/{point}', [PointController::class, 'show'])->name('points.show');
    Route::delete('/points/{point}', [PointController::class, 'destroy'])->name('points.destroy');

    // Rotas para assinatura
    Route::get('/profile/finance/subscription', [SubscriptionController::class, 'index'])->name('profile.finance.subscription');
    Route::post('/profile/finance/subscription', [SubscriptionController::class, 'processSubscription'])->name('profile.finance.subscription.process');

    // Rotas para checkout e pagamentos
    Route::post('/profile/finance/checkout', [PaymentController::class, 'checkout'])->name('profile.finance.checkout');
    Route::get('/profile/finance/checkout/{plan}', function ($plan, Request $request) {
        $stripePriceId = match ($plan) {
            'basico' => env('STRIPE_PRICE_ID_BASICO'),
            'premium' => env('STRIPE_PRICE_ID_PREMIUM'),
            'empresarial' => env('STRIPE_PRICE_ID_EMPRESARIAL'),
            default => throw new \Exception('Plano inválido'),
        };

        return $request->user()->checkout([$stripePriceId => 1], [
            'success_url' => route('checkout-success'),
            'cancel_url' => route('checkout-cancel'),
        ]);
    })->name('checkout-plan');

    // Páginas de sucesso e cancelamento
    Route::get('/profile/finance/checkout/success', [PaymentController::class, 'success'])->name('checkout-success');
    Route::get('/profile/finance/checkout/cancel', [PaymentController::class, 'cancel'])->name('checkout-cancel');

    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::get('/auth/register-login', function () {return view('auth.register-login');})->name('auth.register-login');
Route::get('/auth/form', [AuthController::class, 'showLoginForm'])->name('auth.form');

require __DIR__.'/auth.php';
