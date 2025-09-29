<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountDurationController;
use App\Http\Controllers\backend\BackendController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DurationPriceController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\frontend\BundelFrontendController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\FrontendCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password/update', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');
});
Route::middleware(['CheckAdmin', 'admin.only'])->group(function () {
    Route::get('/backend/users', [UserController::class, 'index'])->name('users');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/user/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
    Route::get('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::get('/bundel/delete/{id}', [BundleController::class, 'destroy'])->name('bundel.delete');
    Route::get('/account/delete/{id}', [AccountController::class, 'destroy'])->name('account.destroy');
    Route::get('/durationprice/delete/{id}', [DurationPriceController::class, 'destroy'])->name('durationprice.delete');
    Route::get('/coupons/delete/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::get('/cover/delete/{id}', [CoverController::class, 'cover'])->name('cover.destroy');
});

Route::middleware('CheckAdmin')->group(function () {
    Route::get('/admin', [BackendController::class, 'admin'])->name('admin');
    Route::get('/backend/product', [ProductController::class, 'index'])->name('product');
    Route::get('/backend/order', [OrderController::class, 'index'])->name('order');
    Route::post('/orders/{order}/mark-paid', [OrderController::class, 'markAsPaidAndSendAccount'])->name('orders.markPaid');
    Route::post('/orders/{order}/resend-email', [OrderController::class, 'resendEmail'])->name('orders.resendEmail');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/backend/account', [AccountController::class, 'index'])->name('account');
    Route::get('/backend/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/backend/bundel', [BundleController::class, 'index'])->name('bundel');
    Route::get('/backend/durationprice', [DurationPriceController::class, 'index'])->name('durationprice');
    Route::get('/backend/coupons', [CouponController::class, 'index'])->name('coupons');
    Route::get('/backend/slider', [SliderController::class, 'index'])->name('slider');
    Route::get('/backend/cover', [CoverController::class, 'index'])->name('cover');

    // user table
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/update', [CategoryController::class, 'update'])->name('categories.update');

    // COVER
    Route::get('/cover/create', [CoverController::class, 'create'])->name('cover.create');
    Route::post('/cover/store', [CoverController::class, 'store'])->name('cover.store');
    Route::get('/cover/edit/{id}', [CoverController::class, 'edit'])->name('cover.edit');
    Route::post('/cover/update', [CoverController::class, 'update'])->name('cover.update');

    // slider
    Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
    Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('/slider/update', [SliderController::class, 'update'])->name('slider.update');

    // product table
    Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');

    // bundel
    Route::get('/bundel/show/{id}', [BundleController::class, 'show'])->name('bundel.show');
    // Route::get('/bundel/delete/{id}', [BundleController::class, 'destroy'])->name('bundel.delete');
    Route::get('/bundel/create', [BundleController::class, 'create'])->name('bundel.create');
    Route::post('/bundel/store', [BundleController::class, 'store'])->name('bundel.store');
    Route::get('/bundel/edit/{id}', [BundleController::class, 'edit'])->name('bundel.edit');
    Route::post('/bundel/update', [BundleController::class, 'update'])->name('bundel.update');

    // account table
    Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
    Route::get('/account/create', [AccountController::class, 'create'])->name('account.create');
    Route::get('/account/edit/{id}', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');

    // durationprice table
    Route::post('/durationprice/store', [DurationPriceController::class, 'store'])->name('durationprice.store');
    Route::get('/durationprice/create', [DurationPriceController::class, 'create'])->name('durationprice.create');
    Route::get('/durationprice/edit/{id}', [DurationPriceController::class, 'edit'])->name('durationprice.edit');
    Route::post('/durationprice/update', [DurationPriceController::class, 'update'])->name('durationprice.update');

    Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/edit/{id}', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::post('/coupons/update', [CouponController::class, 'update'])->name('coupons.update');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::get('/', [FrontendController::class, 'index'])->name('home');
        Route::get('/shop', [FrontendCategoryController::class, 'index'])->name('shop');
        Route::get('/bundles', [BundelFrontendController::class, 'index'])->name('bundles');
        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        // ...
        Route::get('/product', function () {
            return view('include.product');
        });
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact/send', [ContactController::class, 'submitContactForm'])->name('contact.send');
        Route::get('/about', function () {
            $categories = Category::with('products')->get();
            return view('include.about', compact('categories'));
        })->name('about');
        Route::get('/conditions', function () {
            return view('include.conditions');
        })->name('conditions');

        Route::get('/category/{id}', [FrontendCategoryController::class, 'show'])->name('category.products');
        Route::get('/product/{id}', [FrontendController::class, 'show'])->name('product.details');
        Route::get('/bundle/{id}', [FrontendController::class, 'showBundelDetails'])->name('bundle.details');
        Route::middleware(['auth'])->group(function () {
            Route::post('/toggle-favorite', [FavoriteController::class, 'toggleFavorite'])->name('toggle.favorite');
            Route::post('/favorites/remove', [FavoriteController::class, 'removeFavorite'])->name('favorites.remove');
            Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');

            Route::get('/cart', [CartController::class, 'index'])->name('cart');
            Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add'); // For adding items
            Route::patch('/cart/{durationPriceId}', [CartController::class, 'update'])->name('cart.update'); // Changed parameter name
            Route::delete('/cart/{durationPriceId}', [CartController::class, 'remove'])->name('cart.remove'); // Changed parameter name
            Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
            Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        });
        Route::get('/search', [FrontendController::class, 'search'])->name('frontend.search');
        Route::get('/live-search', [FrontendController::class, 'liveSearch'])->name('live.search');
        require __DIR__ . '/auth.php';
    }
);
