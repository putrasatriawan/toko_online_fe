<?php

use App\Http\Controllers\admin\LandingAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\ProductCmsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthFrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BuyerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthFrontendController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthFrontendController::class, 'loginProcess'])->name('login.process');

Route::get('/register', [AuthFrontendController::class, 'register'])->name('register');
Route::post('/register', [AuthFrontendController::class, 'processRegister'])->name('register.process');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/get', [CartController::class, 'get'])->name('cart.get');
Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.updateQty');

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.submit');

Route::get('/tracking-buyer', [BuyerController::class, 'trackingBuyer']);

Route::get('/logout', [AuthFrontendController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('admin.session')->group(function () {
    Route::resource('landing', LandingAdminController::class)->names('admin.landing');
    Route::resource('products', ProductCmsController::class)->names('admin.products');
    Route::resource('orders', OrderAdminController::class)->names('admin.orders');
    Route::put('orders/{id}/status', [OrderAdminController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
});
