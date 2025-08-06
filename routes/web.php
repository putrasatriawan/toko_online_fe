<?php

use App\Http\Controllers\admin\LandingAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\ProductCmsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthFrontendController;

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


Route::get('/logout', [AuthFrontendController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('admin.session')->group(function () {
    Route::resource('landing', LandingAdminController::class)->names('admin.landing');
    Route::resource('products', ProductCmsController::class)->names('admin.products');
    Route::resource('orders', OrderAdminController::class)->names('admin.orders');
    Route::put('orders/{id}/status', [OrderAdminController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
});
