<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use Inertia\Inertia;

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

Route::get('/', [WelcomeController::class, 'welcome']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('services/search', [ServiceController::class, 'search'])->name('services.search');
    Route::resource('services', ServiceController::class);
    Route::get('service/{service}/order', [OrderController::class, 'order'])->name('service.order');
    Route::post('service/{service}/order', [OrderController::class, 'store'])->name('service.order.store');
    Route::get('order/{order}', [OrderController::class, 'complete'])->name('service.order.complete');
    Route::get('orders', [OrderController::class, 'userOrders'])->name('service.orders');
    Route::get('service/{service}/timetable', [OrderController::class, 'timetables'])->name('service.timetable');
    Route::get('user', [ServiceController::class, 'userIndex'])->name('user');
    Route::get('users/{user}', [ServiceController::class, 'userIndex'])->name('users');
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
