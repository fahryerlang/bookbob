<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\WalletController as AdminWalletController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Contact/Message
Route::get('/contact', [MessageController::class, 'create'])->name('contact');
Route::post('/contact', [MessageController::class, 'store'])->name('contact.store');

// Catalog (Public)
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{book:slug}', [CatalogController::class, 'show'])->name('catalog.show');

// User Routes (Authenticated Users)
Route::middleware(['auth', 'user'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Messages (User)
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'userCreate'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'userStore'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');

    // Wallet
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::get('/wallet/topup/request', [WalletController::class, 'topupRequestForm'])->name('wallet.topup.request.form');
    Route::post('/wallet/topup/request', [WalletController::class, 'topupRequest'])->name('wallet.topup.request');
    Route::get('/wallet/topup/transfer', [WalletController::class, 'topupTransferForm'])->name('wallet.topup.transfer.form');
    Route::post('/wallet/topup/transfer', [WalletController::class, 'topupTransfer'])->name('wallet.topup.transfer');
    Route::get('/wallet/topup/gateway', [WalletController::class, 'topupGateway'])->name('wallet.topup.gateway');
    Route::get('/wallet/history', [WalletController::class, 'history'])->name('wallet.history');
    Route::get('/wallet/topup/{topupRequest}', [WalletController::class, 'showTopup'])->name('wallet.topup.show');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{book}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/{wishlist}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
    Route::post('/wishlist/move-all-to-cart', [WishlistController::class, 'moveAllToCart'])->name('wishlist.moveAllToCart');
    Route::delete('/wishlist', [WishlistController::class, 'clear'])->name('wishlist.clear');

    // Reviews
    Route::get('/orders/{order}/review/{book}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/orders/{order}/review/{book}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Coupons
    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::post('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
    Route::get('/coupon/check-first-purchase', [CouponController::class, 'checkFirstPurchase'])->name('coupon.checkFirstPurchase');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Books
    Route::resource('books', AdminBookController::class);

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');

    // Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
    Route::patch('/messages/{message}/read', [AdminMessageController::class, 'markAsRead'])->name('messages.markAsRead');

    // Wallet Management
    Route::get('/wallet', [AdminWalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup-requests', [AdminWalletController::class, 'topupRequests'])->name('wallet.topup-requests');
    Route::get('/wallet/topup-requests/{topupRequest}', [AdminWalletController::class, 'showTopupRequest'])->name('wallet.topup.show');
    Route::post('/wallet/topup-requests/{topupRequest}/approve', [AdminWalletController::class, 'approveTopup'])->name('wallet.topup.approve');
    Route::post('/wallet/topup-requests/{topupRequest}/reject', [AdminWalletController::class, 'rejectTopup'])->name('wallet.topup.reject');
    Route::get('/wallet/manual-topup', [AdminWalletController::class, 'manualTopupForm'])->name('wallet.manual-topup');
    Route::post('/wallet/manual-topup', [AdminWalletController::class, 'manualTopup'])->name('wallet.manual-topup.store');
    Route::get('/wallet/bank-accounts', [AdminWalletController::class, 'bankAccounts'])->name('wallet.bank-accounts');
    Route::post('/wallet/bank-accounts', [AdminWalletController::class, 'storeBankAccount'])->name('wallet.bank-accounts.store');
    Route::put('/wallet/bank-accounts/{bankAccount}', [AdminWalletController::class, 'updateBankAccount'])->name('wallet.bank-accounts.update');
    Route::delete('/wallet/bank-accounts/{bankAccount}', [AdminWalletController::class, 'deleteBankAccount'])->name('wallet.bank-accounts.delete');

    // Promos
    Route::get('/promos', [AdminPromoController::class, 'index'])->name('promos.index');
    Route::get('/promos/create', [AdminPromoController::class, 'create'])->name('promos.create');
    Route::post('/promos', [AdminPromoController::class, 'store'])->name('promos.store');
    Route::get('/promos/{promo}/edit', [AdminPromoController::class, 'edit'])->name('promos.edit');
    Route::put('/promos/{promo}', [AdminPromoController::class, 'update'])->name('promos.update');
    Route::delete('/promos/{promo}', [AdminPromoController::class, 'destroy'])->name('promos.destroy');
    Route::patch('/promos/{promo}/toggle', [AdminPromoController::class, 'toggle'])->name('promos.toggle');

    // Coupons
    Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [AdminCouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}/edit', [AdminCouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}', [AdminCouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');
    Route::patch('/coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
    Route::get('/coupons/generate-code', [AdminCouponController::class, 'generateCode'])->name('coupons.generateCode');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
