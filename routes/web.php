<?php

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\SubscriptionController;
use App\Http\Controllers\Customer\AboutController;
use App\Http\Controllers\Customer\FAQController;
use App\Http\Controllers\Customer\PrivacyPolicyController;
use App\Http\Controllers\Customer\ContactController;

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SubscriptionController as AdminSubscriptionController;
use App\Http\Controllers\Admin\UserPage\AboutController as UserPageAboutController;
use App\Http\Controllers\Admin\UserPage\ContactController as UserPageContactController;
use App\Http\Controllers\Admin\UserPage\FAQController as UserPageFAQController;
use App\Http\Controllers\Admin\UserPage\PolicyController as UserPagePolicyController;
use App\Http\Controllers\Admin\UserPageController;

Route::middleware(['guest'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/masuk', 'login')->name('login');
        Route::post('/masuk', 'login_post')->name('login_post');
        Route::get('/daftar', 'register')->name('register');
        Route::post('/daftar', 'register_post')->name('register_post');
    });
});

Route::get('/keluar', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about.index');
Route::get('/kontak-kami', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak-kami', [ContactController::class, 'store'])->name('contact.store');
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
Route::get('/kebijakan-privasi', [PrivacyPolicyController::class, 'index'])->name('policy.index');

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/pembayaran/langganan/{slug}', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/pembayaran/langganan/{paket}', [SubscriptionController::class, 'store'])->name('subscription.store');

    Route::get('/produk/{slug}', [ProductController::class, 'detail'])->name('products.detail');

    Route::get('/pembayaran', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/pembayaran/{slug}', [CheckoutController::class, 'buy_now'])->name('checkout.buy_now');
    Route::post('/pembayaran', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/pembayaran/{slug}', [CheckoutController::class, 'buy_now_store'])->name('checkout.buy_now_store');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{id}/faktur', [OrderController::class, 'generateInvoice'])->name('orders.invoice');
    Route::put('/pesanan/{id}/terima', [OrderController::class, 'received'])->name('orders.received');

    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('{slug}/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::post('/keranjang/{id}/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/keranjang/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});

Route::prefix('dashboard')->middleware(['auth', 'admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard.index');
    });

    Route::controller(UserPageController::class)->group(function () {
        Route::get('/konten-pengguna', 'index')->name('dashboard.content.index');
    });

    Route::controller(UserPageAboutController::class)->group(function () {
        Route::get('/konten-pengguna/tentang-kami', 'index')->name('dashboard.about.index');

        Route::get('/konten-pengguna/tentang-kami/ubah-header', 'changeHeader')->name('dashboard.about.edit.header');
        Route::put('/konten-pengguna/tentang-kami/ubah-header', 'changeHeaderUpdate')->name('dashboard.about.update.header');

        Route::get('/konten-pengguna/tentang-kami/ubah-content', 'changeContent')->name('dashboard.about.edit.content');
        Route::put('/konten-pengguna/tentang-kami/ubah-content', 'changeContentUpdate')->name('dashboard.about.update.content');
    });

    Route::controller(UserPageContactController::class)->group(function () {
        Route::get('/konten-pengguna/kontak-kami', 'index')->name('dashboard.contact.index');

        Route::get('/konten-pengguna/kontak-kami/ubah-header', 'changeHeader')->name('dashboard.contact.edit.header');
        Route::put('/konten-pengguna/kontak-kami/ubah-header', 'changeHeaderUpdate')->name('dashboard.contact.update.header');

        Route::get('/konten-pengguna/kontak-kami/ubah-data-toko', 'changeData')->name('dashboard.contact.edit.data');
        Route::put('/konten-pengguna/kontak-kami/ubah-data-toko', 'changeDataUpdate')->name('dashboard.contact.update.data');

        Route::get('/konten-pengguna/kontak-kami/show-message/{id}', 'showMessage')->name('dashboard.contact.show');
        Route::delete('/konten-pengguna/kontak-kami/show-message/{id}', 'deleteMessage')->name('dashboard.contact.delete.message');
    });

    Route::controller(UserPageFAQController::class)->group(function () {
        Route::get('/konten-pengguna/faq', 'index')->name('dashboard.faq.index');
        Route::get('/konten-pengguna/faq/ubah-judul', 'changeTitle')->name('dashboard.faq.edit.title');
        Route::put('/konten-pengguna/faq/ubah-judul', 'changeTitleUpdate')->name('dashboard.faq.update.title');

        Route::get('/konten-pengguna/faq/tambah-qna', 'addList')->name('dashboard.faq.create.qna');
        Route::post('/konten-pengguna/faq/tambah-qna', 'addNewList')->name('dashboard.faq.store.qna');

        Route::get('/konten-pengguna/faq/ubah-qna/{id}', 'changeList')->name('dashboard.faq.edit.qna');
        Route::put('/konten-pengguna/faq/ubah-qna/{id}', 'changeListUpdate')->name('dashboard.faq.update.qna');

        Route::delete('/konten-pengguna/faq/hapus-qna/{id}', 'deleteList')->name('dashboard.faq.delete.qna');
    });

    Route::controller(UserPagePolicyController::class)->group(function () {
        Route::get('/konten-pengguna/kebijakan-privasi', 'index')->name('dashboard.privacy.index');


        Route::get('/konten-pengguna/kebijakan-privasi/ubah-header', 'changeHeader')->name('dashboard.privacy.edit.header');
        Route::put('/konten-pengguna/kebijakan-privasi/ubah-header', 'changeHeaderUpdate')->name('dashboard.privacy.update.header');

        Route::get('/konten-pengguna/kebijakan-privasi/ubah-content', 'changeContent')->name('dashboard.privacy.edit.content');
        Route::put('/konten-pengguna/kebijakan-privasi/ubah-content', 'changeContentUpdate')->name('dashboard.privacy.update.content');
    });

    Route::controller(AdminProductController::class)->group(function () {
        Route::get('/produk', 'index')->name('dashboard.products.index');
        Route::get('/produk/tambah', 'create')->name('dashboard.products.create');
        Route::post('/produk/tambah', 'store')->name('dashboard.products.store');
        Route::get('/produk/edit/{slug}', 'edit')->name('dashboard.products.edit');
        Route::put('/produk/edit/{slug}', 'update')->name('dashboard.products.update');
        Route::delete('/produk/delete/{id}', 'destroy')->name('dashboard.products.destroy');
    });

    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('/pesanan', 'index')->name('dashboard.orders.index');
        Route::get('/pesanan/kelola/{id}', 'manage')->name('dashboard.orders.manage');
        Route::post('/pesanan/kirim/{id}', 'send')->name('dashboard.orders.send');
        Route::post('/pesanan/tolak/{id}', 'reject')->name('dashboard.orders.reject');

        Route::get('/pesanan/report', 'generateReport')->name('orders.report');
    });

    Route::controller(AdminSubscriptionController::class)->group(function () {
        Route::get('/langganan', 'index')->name('dashboard.subscriptions.index');
        Route::post('/langganan/setujui/{id}', 'approve')->name('dashboard.subscriptions.approve');
        Route::post('/langganan/tolak/{id}', 'reject')->name('dashboard.subscriptions.reject');

        Route::get('/langganan/report', 'generateReport')->name('subscriptions.report');
    });


    Route::controller(UserController::class)->group(function () {
        Route::get('/pengguna', 'index')->name('dashboard.users.index');
    });

    Route::controller(AdminProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('dashboard.profile.index');
    });
    
});

Route::middleware('auth')->group(function () {
    Route::put('/profile', [ProfileController::class, 'profile_update'])->name('profile.update');
    Route::put('/profile/ubah-password', [ProfileController::class, 'change_password'])->name('profile.change_password');
});


Route::fallback(function () {
    return view('pages.error.404');
});